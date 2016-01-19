<?php

use yii\helpers\Html;

?>
<h1 class="alert alert-danger" style="margin-top: 100px;">Unfortunately something is wrong with your Excel spreadsheet :-(</h1>
<div>
    <? foreach ($import_errors as $row => $row_array) : ?>
        <h3>Row # <?= $row; ?>:</h3>
        <? foreach ($row_array as $key => $import_error_array) : ?>
            <? foreach($import_error_array as $import_error) : ?>
                <p class="bg-danger" style="font-size: 1.5em; padding: 3px 5px;"><?= $import_error; ?></p>  
            <? endforeach; ?>
        <? endforeach; ?>       
    <? endforeach; ?>
</div>
<h2 style="margin-top: 50px;">
   Please correct the above listed errors in the specified rows in the import spreadsheet file, <?= Html::a('return back to the previous page', Yii::$app->request->referrer); ?>, and recommit the spreadsheet.  
</h2>