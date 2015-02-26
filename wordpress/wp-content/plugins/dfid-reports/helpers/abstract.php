<?php

/**
 * Class AbstractHelper
 *
 * This class has the general methods for reporting.
 * It will be extended by each report type
 *
 */
abstract class AbstractHelper
{
    /**
     * Percentage sign used for output values format
     */
    const PERCENTAGE_SIGN = '%';

    /**
     * This property will contain the questions total points
     * The values will be cached to avoid multiple database queries for the same category
     *
     * @var array
     */
    private $_questionsPointsCache = array();

    /**
     * Generate the csv string
     *
     * @return string
     */
    public function getCsv()
    {
        $values = $this->getReportValues();
        $columns = $this->getCsvColumns();

        $csv = '"' . implode('","', $columns) . '"' . "\n";

        foreach ($values as $value) {
            $csv .= '"' . implode('","', $value) . '"' . "\n";
        }

        return $csv;
    }

    /**
     * Return the export file name
     *
     * @return string
     */
    abstract public function getExportFileName();

    /**
     * Load total number of finished quizzes based on option value (department / role value)
     *
     * @param $optionValue
     *
     * @return integer
     */
    public function getTotalQuizCount($optionValue)
    {
        global $wpdb;
        $query = '
          SELECT count(*) FROM ' . $wpdb->prefix . 'watupro_student_answers
          WHERE question_id = ' . $this->getOptionId() . ' and answer = "' . $optionValue . '"
        ';

        return $wpdb->get_var($query);
    }

    /**
     * Get the average total score based on option value (department / role value)
     *
     * @param $optionValue
     *
     * @return float
     */
    public function getAverageTotalScore($optionValue)
    {
        global $wpdb;
        $query = '
          SELECT DISTINCT(taking_id) FROM ' . $wpdb->prefix . 'watupro_student_answers
          WHERE question_id = ' . $this->getOptionId() . ' and answer = "' . $optionValue . '"
        ';

        $results = $wpdb->get_results($query);

        $scoreSum = 0;
        foreach($results as $result) {
            $totalMaximumPoints = 0;
            $query = '
                SELECT question_id from ' . $wpdb->prefix . 'watupro_student_answers
                WHERE taking_id = "' . $result->taking_id . '"
            ';

            $studentAnswers = $wpdb->get_results($query);

            foreach($studentAnswers as $studentAnswer) {
                $totalMaximumPoints += $this->getQuestionTotalPoints($studentAnswer->question_id);
            }

            $query = '
            SELECT points from ' . $wpdb->prefix . 'watupro_taken_exams
            WHERE ID = "' . $result->taking_id . '"
        ';

            $scoreSum += round($wpdb->get_var($query) / $totalMaximumPoints * 100);
        }

        return round($scoreSum / count($results));
    }

    /**
     * Calculate the average score for option value (department / role value) and category id
     *
     * @param $optionValue
     * @param $categoryId
     *
     * @return float
     */
    public function getCategoryScore($optionValue, $categoryId)
    {
        global $wpdb;
        $query = '
          SELECT DISTINCT(taking_id) FROM ' . $wpdb->prefix . 'watupro_student_answers
          WHERE question_id = ' . $this->getOptionId() . ' and answer = "' . $optionValue . '"
        ';

        $results = $wpdb->get_results($query);
        $takingIds = array();
        foreach($results as $result) {
            // Just the takings for the current department
            $takingIds[] = $result->taking_id;
        }

        $query = '
          SELECT ID FROM ' . $wpdb->prefix . 'watupro_question
          WHERE cat_id = ' . $categoryId . '
        ';

        $results = $wpdb->get_results($query);
        $questionsForCategory = array();
        foreach($results as $result) {
            $questionsForCategory[] = $result->ID;
        }

        $query = '
          SELECT points, question_id FROM ' . $wpdb->prefix . 'watupro_student_answers
          WHERE taking_id IN (' . implode(',', $takingIds) . ') and question_id IN (' . implode(',', $questionsForCategory) . ')
        ';
        $results = $wpdb->get_results($query);

        $scoreSum = 0;
        foreach($results as $result) {
            $questionPoints = $this->getQuestionTotalPoints($result->question_id);
            if ($questionPoints != 0) {
                $scoreSum += ($result->points / $questionPoints * 100);
            }
        }

        return round($scoreSum / count($results));
    }

    /**
     * Return all the categories from database
     *
     * @return array
     */
    public function getAllCategories()
    {
        global $wpdb;
        $query = '
          SELECT * FROM ' . $wpdb->prefix . 'watupro_qcats
          ORDER BY name ASC
        ';

        return $wpdb->get_results($query);
    }

    /**
     * Format the category name. Only the first letter will be used on frontend
     *
     * @param $categoryName
     *
     * @return string
     */
    public function formatCategoryName($categoryName)
    {
        $categoryName = explode(".", $categoryName);

        return $categoryName[0];
    }

    /**
     * Return the report values. This method will be implemented in the child classes
     *
     * @return array
     */
    abstract public function getReportValues();

    /**
     * Return the report CSV columns. This method will be implemented in the child classes
     *
     * @return array
     */
    abstract protected function getCsvColumns();

    /**
     * Return the option id for departments / roles. This method will be implemented in the child classes
     *
     * @return array
     */
    abstract protected function getOptionId();

    /**
     * Calculate the question total points
     *
     * @param $questionId
     * @return mixed
     */
    protected function getQuestionTotalPoints($questionId)
    {
        global $wpdb;
        /** Cache the question total points */
        if (!isset($this->_questionsPointsCache[$questionId])) {
            $query = '
                SELECT sum(point) as points
                FROM ' . $wpdb->prefix . 'watupro_answer
                WHERE question_id = ' . $questionId . '
            ';

            $this->_questionsPointsCache[$questionId] = $wpdb->get_var($query);
        }

        return $this->_questionsPointsCache[$questionId];
    }

    /**
     * Format the output values
     *
     * @param $value
     *
     * @return string
     */
    public function formatOutputValue($value)
    {
        return $value . self::PERCENTAGE_SIGN;
    }
}