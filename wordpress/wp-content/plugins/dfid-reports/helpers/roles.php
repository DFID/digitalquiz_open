<?php
require_once REPORTS_MODULE_DIRECTORY . "helpers" . DIRECTORY_SEPARATOR . "abstract.php";

/**
 * Class RolesHelper
 *
 * This class is used to generate the role based reports
 */
class RolesHelper extends AbstractHelper
{
	/**
	 * The role option from the database.
	 */
	const ROLE_OPTION_ID = 10;

    /**
     * Calculate and return the report values
     *
     * @return array
     */
    public function getReportValues()
    {
        $values = array();
        $roles = $this->getAllRoles();
        $categories = $this->getAllCategories();
        foreach($roles as $key => $role) {
            $values[$key] = array(
                'role' => $role->answer,
                'number_of'  => $this->getTotalQuizCount($role->answer),
                'average_total_score' => $this->formatOutputValue($this->getAverageTotalScore($role->answer)),
            );

            foreach($categories as $category) {
                $values[$key]['cat_' . $category->ID] = $this->formatOutputValue($this->getCategoryScore($role->answer, $category->ID));
            }
        }

        return $values;
    }

	/**
	 * Return the export file name
	 *
	 * @return string
	 */
	public function getExportFileName()
	{
		return 'roles-report.csv';
	}

    /**
     * Load all the roles from database
     *
     * @return array
     */
    public function getAllRoles()
    {
        global $wpdb;
        $query = '
          SELECT DISTINCT(answer) as answer
          FROM ' . $wpdb->prefix . 'watupro_student_answers where question_id = ' . self::ROLE_OPTION_ID . '
          ORDER BY answer ASC';;

        return $wpdb->get_results($query);
    }

    /**
     * Return the report CSV columns.
     *
     * @return array
     */
    protected function getCsvColumns()
    {
        $columns = array('Role', 'Times taken', 'AVG Total Score');
        $categories = $this->getAllCategories();
        foreach($categories as $category) {
            $columns[] = $this->formatCategoryName($category->name);
        }

        return $columns;
    }

    /**
     * Return the option id for roles.
     *
     * @return array
     */
    protected function getOptionId()
    {
        return self::ROLE_OPTION_ID;
    }
}