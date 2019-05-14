<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this \yii\web\View */
/* @var $panel yii\debug\panels\UserPanel */
?>

<h1><?= Html::encode($panel->getName()) ?></h1>

<?php
if (isset($panel->data['identity'])) {
    $items = [
        'nav' => [$panel->getName()],
        'content' => [
            "<h2>{$panel->getName()} Info</h2>" . DetailView::widget([
                'model' => $panel->data['identity'],
                'attributes' => $panel->data['attributes']
            ])
        ]
    ];
    if ($panel->data['rolesProvider'] || $panel->data['permissionsProvider']) {
        $items['nav'][] = 'Roles and Permissions';
        $items['content'][] = $this->render('roles', ['panel' => $panel]);
    }

    if ($panel->canSwitchUser()) {
        $name = Html::encode($panel->getName());
        $items['nav'][] = "Switch {$name}";
        $items['content'][] = $this->render('switch', ['panel' => $panel]);
    }

    ?>
    <ul class="nav nav-tabs">
        <?php
        foreach ($items['nav'] as $k => $item) {
            echo Html::tag(
                'li',
                Html::a(Html::encode($item), '#u-tab-' . $k, [
                    'class' => $k === 0 ? 'nav-link active' : 'nav-link',
                    'data-toggle' => 'tab',
                    'role' => 'tab',
                    'aria-controls' => 'u-tab-' . $k,
                    'aria-selected' => $k === 0 ? 'true' : 'false'
                ]),
                [
                    'class' => 'nav-item'
                ]
            );
        }
        ?>
    </ul>
    <div class="tab-content">
        <?php
        foreach ($items['content'] as $k => $item) {
            echo Html::tag('div', $item, [
                'class' => $k === 0 ? 'tab-pane fade active show' : 'tab-pane fade',
                'id' => 'u-tab-' . $k
            ]);
        }
        ?>
    </div>
    <?php

} else {
    echo 'Is guest.';
} ?>
