<?php
require_once REPORTS_MODULE_DIRECTORY . "helpers" . DIRECTORY_SEPARATOR . "departments.php";
$departmentsHelper = new DepartmentsHelper();
$departments = $departmentsHelper->getAllDepartments();
$categories = $departmentsHelper->getAllCategories();
?>
<div class="wrap">
	<h1><?php _e('Departments report', 'reports')?></h1>
	<?php if(!sizeof($departments)):?>
		<p><?php _e('There are no records that match your search criteria', 'reports')?></p>
	<?php else:?>
		<form action="reports" method="post">
			<input type="hidden" value="download_departments_csv" name="action">
			<p><input type="submit" value="<?php _e('Export csv', 'reports')?>"></p>
		</form>
		<table class="widefat">
			<tr>
				<th><?php _e('Department', 'reports')?></th>
				<th><?php _e('Times taken', 'reports')?></th>
                <th><?php _e('AVG Total Score', 'reports')?></th>
                <?php foreach ($categories as $category): ?>
                    <th><?php echo $departmentsHelper->formatCategoryName($category->name); ?></th>
                <?php endforeach; ?>
			</tr>
            <?php foreach ($departments as $department): ?>
                <?php $class = ('alternate' == @$class) ? '' : 'alternate';?>
                <tr class="<?php echo $class?>">
                    <td><?php echo $department->answer; ?></td>
                    <td><?php echo $departmentsHelper->getTotalQuizCount($department->answer); ?></td>
                    <td><?php echo $departmentsHelper->formatOutputValue($departmentsHelper->getAverageTotalScore($department->answer)); ?></td>
                    <?php foreach ($categories as $category): ?>
                        <td><?php echo $departmentsHelper->formatOutputValue($departmentsHelper->getCategoryScore($department->answer, $category->ID)); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
		</table>
	<?php endif; ?>
</div>