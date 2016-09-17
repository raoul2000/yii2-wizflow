**THIS IS A WORK IN PROGRESS**

# A Wizard Implementation

The word *wizard* does not only refers to some Gandalf guy or any other old man wearing a funny hat and loaded with super magic power. In the world of user interface a wizard is a design pattern that can be applied in the case where *the user wants to achieve a single goal which can be broken down into dependable sub-tasks* (from [ui-patterns.com](http://ui-patterns.com/patterns/Wizard)).

To learn more about wizard, you'd better read [Designing Interfaces](http://designinginterfaces.com/patterns/wizard/).

## The problem

The problem is simple : how can we implement a complex step-by-step process that will guide the user to its final goal ? The complexity can come from the fact that depending on the choice made by the user, he/she can be guided through different steps. In other words, we are considering a case where there would be several path (ordered sequence of steps) to go from the first step to the last one (the goal).

The purpose of this Yii2 extension is to solve this problem using the workflow paradigm implemented by **yii2-workflow** extension.

# Install Examples

The *yii2-wizflow* extension comes with a set of Yii2 models, views and actions dedicated to provide a very basic wizard.

Starting from a fresh Yii2 install based on the Basic template and located in folder `APP_FOLDER` :

- copy all folders from `APP_FOLDER/vendor/raoul2000/yii2-wizflow/example` into `APP_FOLDER`. Example models and views are copied into your yii2 application
- declare the **WizflowManager** component in `APP_FOLDER/conf/web.php`. This component implements all the logic between the workflow definition and model/view. It also handle the persistence layer by saving user entries into the current session.

```php
'components' => [
  'wizflowManager' => [
    'class' => '\raoul2000\wizflow\wizflowManager'
  ],
  // etc ...
```

- declare the **workflowSource** component in `APP_FOLDER/conf/web.php`. This is the standard yii2-wizflow source component.

```php
'components' => [
  'workflowSource' => [
    // use default settings : workflow definition is stored in an object and can be
    // retrieved with the getDefinition() method
    'class' => '\raoul2000\workflow\source\file\WorkflowFileSource'
  ],
// etc ...
```

- add a new action in `APP_FOLDER/controllers/SiteController.php`. This action is used during wizard navigation.

```php
public function actions()
{
    return [
      // other actions ...
        'wizflow' => [
            'class' => '\raoul2000\wizflow\WizardPlayAction'
        ],
    ];
}
```
- add the *finish* action in `APP_FOLDER/controllers/SiteController.php`. This action is invoked at the end of the wizard, to display a summary of choices made by the user.

```php
public function actionFinish()
{
  return $this->render('finish',[
    'path' => Yii::$app->wizflowManager->getPath()
  ]);
}
```

- navigate to [http://host/index.php?r=site/wizflow](http://host/index.php?r=site/wizflow)
- enjoy
