<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('frontTheme', dirname(dirname(__DIR__)) . '/themes/noda');
Yii::setAlias('backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('appRoot', '/'.basename(dirname(dirname(dirname(__DIR__)))));
Yii::setAlias('webRoot', dirname(dirname(dirname(__DIR__))));