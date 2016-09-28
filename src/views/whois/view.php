<?php

use hipanel\modules\domainchecker\assets\WhoisAsset;

WhoisAsset::register($this);
$message = Yii::t('hipanel/domainchecker', '');
$this->registerJs("
$('#whois').whois({
    '': '',
});
");

?>

<div id="whois">
    <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0"
             aria-valuemax="100" style="width: 100%">
            <span class="sr-only">100% Complete</span>
        </div>
    </div>
</div>


