<?php
require_once REPORTS_MODULE_DIRECTORY . "helpers" . DIRECTORY_SEPARATOR . "abstract.php";
/**
 * Class DepartmentsHelper
 *
 * This class is used to generate the department based reports
 */
class DepartmentsHelper extends AbstractHelper
{
    /**
     * The department option from the database.
     */
    const DEPARTMENT_OPTION_ID = 1;

    /**
     * Calculate and return the report values
     *
     * @return array
     */
    public function getReportValues()
    {
        $values = array();
        $categories = $this->getAllCategories();
        $departments = $this->getAllDepartments();
        foreach ($departments as $key => $department) {
            $values[] = array(
                'department' => $department->answer,
                'number_of' => $this->getTotalQuizCount($department->answer),
                'average_total_score' => $this->formatOutputValue($this->getAverageTotalScore($department->answer))
            );

            foreach($categories as $category) {
                $values[$key]['cat_' . $category->ID] = $this->formatOutputValue($this->getCategoryScore($department->answer, $category->ID));
            }
        }

        return $values;
    }

    /**
     * Load all the departments from database
     *
     * @return array
     */
    public function getAllDepartments()
    {
        global $wpdb;
        $query = '
          SELECT DISTINCT(answer) as answer
          FROM ' . $wpdb->prefix . 'watupro_student_answers where question_id = ' . self::DEPARTMENT_OPTION_ID . '
          ORDER BY answer ASC';

        return $wpdb->get_results($query);
    }

    /**
     * Return the report CSV columns.
     *
     * @return array
     */
    protected function getCsvColumns()
    {
        $columns = array('Department', 'Times taken', 'AVG Total Score');
        $categories = $this->getAllCategories();
        foreach($categories as $category) {
            $columns[] = $this->formatCategoryName($category->name);
        }

        return $columns;
    }

    /**
     * Return the export file name
     *
     * @return string
     */
    public function getExportFileName()
    {
        return 'departments-report.csv';
    }

    /**
     * Return the option id for departments.
     *
     * @return array
     */
    protected function getOptionId()
    {
        return self::DEPARTMENT_OPTION_ID;
    }
}