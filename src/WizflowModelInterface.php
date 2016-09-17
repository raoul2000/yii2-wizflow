<?php

namespace raoul2000\wizflow;

/**
 * Interface that must be implemented by all models used by the
 * wizflow manager component
 */
interface WizflowModelInterface {
  /**
   * Returns a string description of the model. This string is used to display
   * user choices
   * @return string description of the model attributes
   */
  public function summary();
}
