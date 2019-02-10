<?php
class Validate {
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct() {
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()) {
		foreach($items as $item => $rules) {
			foreach($rules as $rule => $rule_value) {

				$value = trim($source[$item]);

				if($rule === 'required' && $rule_value === true && empty($value)) {
					$this->addError("All fields are required.");
                } else if (!empty($value)) {

					switch($rule) {
						case 'min':
							if(strlen($value) < $rule_value) {
                                $rule_value = ucwords($rule_value);
                                $item = ucwords($item);
								$this->addError("{$item} must be a minimum of {$rule_value} characters.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value) {
                                $rule_value = ucwords($rule_value);
                                $item = ucwords($item);
								$this->addError("{$item} must be a maximum of {$rule_value} characters.");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]) {
                                $rule_value = ucwords($rule_value);
                                $item = ucwords($item);
								$this->addError("{ucwords($rule_value)} must match {$item}.");
							}
						break;
						case 'unique':
							$check = $this->_db->get('users', array($item, '=', $value));
							if($check->count()) {
                                $item = ucwords($item);
								$this->addError("{$item} is already in use.");
							}
						break;
					}

                }

				if($rule === 'url' && $rule_value === true && empty($value) === false) {
                    if(filter_var($value, FILTER_VALIDATE_URL) === false) {
                        $this->addError("You must enter a valid URL.");
                    }
                }
                if($rule === 'email' && $rule_value === true) {
                    if(filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
                        $this->addError("You must enter a valid email address.");
                    }
                }

			}
		}

		if(empty($this->_errors)) {
			$this->_passed = true;
		}

		return $this;
	}

	protected function addError($error) {
		$this->_errors = $error;
	}

	public function passed() {
		return $this->_passed;
	}

	public function errors() {
		return $this->_errors;
	}
}