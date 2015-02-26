<?php
/**
 * Class FreeFormAnswersHelper
 *
 * This class is used to generate the free form answers report
 *
 */
class FreeFormAnswersHelper
{
    /**
     * String for the date format
     */
    const DATE_FORMAT = 'd M Y';

    /**
     * Load all questions from database
     *
     * @return array
     */
    public function getAllQuestions()
    {
        global $wpdb;
        $query = '
          SELECT *
          FROM ' . $wpdb->prefix . 'watupro_question
          WHERE answer_type = "textarea"
          ORDER BY question ASC';

        return $wpdb->get_results($query);
    }

    /**
     * Load all answers for a specific question
     *
     * @param $questionId
     *
     * @return array
     */
    public function getQuestionAnswers($questionId)
    {
        global $wpdb;
        $query = '
          SELECT answers.*, exam.email, exam.date
          FROM ' . $wpdb->prefix . 'watupro_student_answers as answers
          LEFT JOIN ' . $wpdb->prefix . 'watupro_taken_exams as exam ON answers.taking_id = exam.ID
          WHERE question_id = ' . $questionId . '
          ORDER BY answer ASC';

        return $wpdb->get_results($query);
    }

    /**
     * Load the category name based on category ID
     *
     * @param $categoryId
     *
     * @return string
     */
    public function getCategoryNameById($categoryId)
    {
        global $wpdb;
        $query = '
          SELECT `name`
          FROM ' . $wpdb->prefix . 'watupro_qcats
          WHERE ID = ' . $categoryId;

        return $wpdb->get_var($query);
    }

    /**
     * Format the date from database
     *
     * @param $date
     * @return string
     */
    public function formatDate($date)
    {
        return date(self::DATE_FORMAT, strtotime( $date ));
    }
}