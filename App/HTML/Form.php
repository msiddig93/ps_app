<?php
namespace App\HTML;

class Form
{
	private static $data;
	
	function __construct($data = array())
	{
		self::$data = $data;
	}

	private function getValue($index)
	{
		if (is_object(self::$data)) {
			return isset(self::$data->$index) ? self::$data->$index : null;
		}
		return isset(self::$data[$index]) ? self::$data[$index] : null;
	}

	private function group($html)
	{
		return "<div class='form-group'>".$html."</div>";
	}

	public function getAttributes($attributes)
	{
		$attr = '';

		foreach ($attributes as $key => $value) {
			$attr .= $key .' = "'.$value.'" ';
		}

		return $attr;
	}

	public function input($name ,$lable = '' , $attributes = array() )
	{
		$lable = $lable != '' ? '<label>'.$lable.'</label>' : '';

		$input = '<input 
						  name="'.$name.'"
						  '.$this->getAttributes($attributes).'
						  value = "'.$this->getValue($name).'"    
				  />';
		if ( $lable != '' ) {
			return $this->group($lable.$input);
		}
		return $lable.$input;
	}

	public function select($name , $lable = '', $options , $attributes = array() , $frist_blank = false )
	{
		$lable = $lable != '' ? '<label>'.$lable.'</label>' : '';

		$select = '<select name="'.$name.'" '.$this->getAttributes($attributes).' >';
			
			$attrV = '';

			if ($frist_blank) {
				$select .='<option  value=""></option>';
			}
			foreach ($options as $k => $v) {
				if ($k == $this->getValue($name))
				{
					$attrV = 'selected';
				}
				else
                {
                    $attrV = '';
                }

				$select .='<option '.$attrV.' value="'.$k.'">'.$v.'</option>';
			}
		$select .='</select>';

		if ( $lable != '' ) {
			return $this->group($lable.$select);
		}

		return $lable.$select;
	}

	public function textarea($name ,$lable = '' , $attributes = array() )
	{
		$lable = $lable != '' ? '<label>'.$lable.'</label>' : '';

		$textarea = '<textarea 
						  name="'.$name.'"
						  '.$this->getAttributes($attributes).'    
				  >'.$this->getValue($name).'</textarea>';
		if ( $lable != '' ) {
			return $this->group($lable.$textarea);
		}
		return $lable.$textarea;
	}



	public function button($attributes = array())
	{
		// Form Attributes .

		$type  = isset($attributes['type']) ? $attributes['type']: 'text';
		$value  = isset($attributes['value']) ? $attributes['value']: '';
		$id  = isset($attributes['id']) ? $attributes['id']: '';
		$class  = isset($attributes['class']) ? $attributes['class']: '';
		$name  = isset($attributes['name']) ? $attributes['name']: '';	

		$button = '<button  type="'.$type .'" 
						  id="'.$id.'" 
						  name="'.$name.'" 
						  class="'.$class.'"
				  >'.$value.'</button>';
		return $button;
	}

}