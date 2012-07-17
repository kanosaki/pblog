<?php
if ( !function_exists('json_encode') )
{
  function json_encode( $array ) 
  {
    if( !is_array($array) )
      return _js_encValue( $array );

    $assoc = FALSE;
    if ( array_diff(array_keys($array),range(0,count($array)-1)) )
      $assoc = TRUE;

    $data = array();
    foreach( $array as $key=>$value )
    {
      if ( $assoc )
      {
        if ( !is_numeric($key) )
          $key = preg_replace('/(["\\\])/u','\\\\$1',$key );
        $key = '"'.$key.'"';
      }
      $value = _js_encValue( $value );
      $data[] = ($assoc ? "$key:$value" : $value);
    }
    if ( $assoc )
      return "{".implode(',',$data)."}";
    else
      return "[".implode(',',$data)."]";
  }

  function _js_encValue( $value )
  {
    if ( is_array($value) )
      return json_encode( $value );
    else if ( is_bool($value) )
      return ($value ? 'true' : 'false');
    else if ( $value === NULL )
      return 'null';
    else if ( is_string($value) )
      return '"'._js_toU16Entities($value).'"';
    else if ( is_numeric($value) )
      return $value;
    return '"'.$value.'"';
  }

  function _js_toU16Entities( $string )
  {
    $len = mb_strlen( $string, 'UTF-8' );
    $str = '';
    $strAry = preg_split( '//u', $string );
    for ( $idx=0, $len=count($strAry); $idx < $len; $idx++ )
    {
      $code = $strAry[$idx];
      if ( $code === '' ) continue;
      if ( strlen($code) > 1 )
      {
        $hex = bin2hex( mb_convert_encoding($code,'UTF-16','UTF-8') );
        if ( strlen($hex) == 8 ) // surrogate pair
          $str .= vsprintf( '\u%04s\u%04s', str_split($hex,4) );
        else
          $str .= sprintf( '\u%04s', $hex );
      } else {
        switch ( $code )
        {
          case '"':
          case '/':
          case '\\':
            $code = '\\'.$code;
        }
        $str .= $code;
      }
    }
    $str = str_replace( array("\r\n","\r","\n"), array('\r\n','\r','\n'), $str );
    return $str;
  }
}
?>
