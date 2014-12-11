<?php

namespace Studip\Mobile;

/**
 * @author      <mlunzena@uos.de>
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GPL version 2
 * @category    Stud.IP
 * @since       2.5
 */
class DelegatingPhpTemplate extends \Flexi_PhpTemplate {
  function _render() {

    extract($this->_attributes);

    # include template, parse it and get output
    ob_start();
    require $this->_template;
    $content_for_layout = ob_get_clean();


    # include layout, parse it and get output
    if (isset($this->_layout)) {
      $defined = get_defined_vars();
      unset($defined['this']);
      $content_for_layout = $this->_layout->render(array_merge($this->_attributes, $defined));
    }

    return $content_for_layout;
  }

    function __call($name, $arguments)
    {
        if ($classes = @$this->_options['view_helper_classes']) {
            foreach ($classes as $class) {
                if (method_exists($class, $name)) {
                    array_unshift($arguments, $this);
                    return call_user_func_array(array($class, $name), $arguments);
                }
            }
        }

        throw new \BadMethodCallException('Method "' . $name . '" does not exist.');
    }
}
