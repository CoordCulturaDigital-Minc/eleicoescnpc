<?php 
/**
 * Instead valitade, this class should apply a chain of filters over
 * a filter to change its value.
 */
class Filter {
    public $fields_rules = array(
        'step1' => array(
            'candidate-phone-1' => array('remove_empty_mask','trim_spaces_and_undescore')
        ),
        'register' => array(
            'user_birth' => array('remove_empty_mask','trim_spaces_and_undescore'),
            'user_cpf' => array('remove_empty_mask','trim_spaces_and_undescore')
        )
    );

    public function apply($s, $f, &$v) {
        if(isset($this->fields_rules[$s]) && isset($this->fields_rules[$s][$f])) {
            foreach($this->fields_rules[$s][$f] as $function) {
                $v = call_user_func(array($this, $function), $v);
            }
            return true;
        }
        return false;;
    }

    static function trim_spaces_and_undescore($v) {
        return preg_replace('/(^[ _]*|[ _]*$)/', '', $v);
    }

    static function remove_empty_mask($v) {
        if(preg_match('/^\(__\) ____+/', $v)) {
            return '';
        }
        return $v;
    }
}

 ?>