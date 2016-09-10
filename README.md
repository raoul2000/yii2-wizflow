**THIS IS A WORK IN PROGRESS**

# A Wizard Implementation

The word *wizard* does not only refers to Gandalf or any other old man wearing a funny hat and loaded with super magic power. In the world of user interface a wizard is a design pattern that can be applied in the case where *the user wants to achieve a single goal which can be broken down into dependable sub-tasks* (from [ui-patterns.com](http://ui-patterns.com/patterns/Wizard)).

To learn more about wizard, please refer to [Designing Interfaces](http://designinginterfaces.com/patterns/wizard/).

## The problem

The problem is simple : how can we implement a complex step-by-step process that will guide the user to its final goal ? The complexity can come from the fact that depending on the choice made by the user, he/she can be guided through different steps. In other words, we are considering a case where that would be several path (ordered sequence of steps) to go from the first step to the last one (the goal).

The purpose of this Yii2 extension is to solve this problem using the workflow paradigm implemented by **yii2-workflow** extension.
