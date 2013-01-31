<?php
/**
 * RC4 aka CipherSaber (1 and 2) encryption and decryption with base64 encoding
 * For more info on CS algorithm go to http://ciphersaber.gurus.com/
 * Based on Ian Gulliver script posted on http://www.xs4all.nl/~cg/ciphersaber/
 * (I bet that guy is a PERL guru, but doesn't understand PHP at all)
 *
 * © 2002-2003 by Emilis Dambauskas under Artistic license (open-source)
 *
 * @access public
 * @author Emilis Dambauskas * emilis@gildija.lt * ICQ#70382138 * www.emilis.tk
 * @created 2003-04-03 01:09
 * @modified 2003-04-03 23:22
 * @version 1.2 (fixed a bug in binEncrypt and fixed code that emmitted
 *   warnings in method _cs, thanks alot to Dallas Pool and Peter Kelly)
 * @package Cheap Tricks Library
 *
 * $Id: ctl.CipherSaber.class.php,v 1.0 2003/04/03 02:01:00 lunaticlt Exp $
 **/


/**
 * Methods:
 *     ctlCipherSaber($csl=1) : constructor (also sets CS2 N if needed)
 *     encrypt($str, $key) : encrypts string with key and base64
 *     decrypt($str, $key) : decrypts base64 string with key
 *     binEncrypt($str, $key) : encrypts string without base64
 *     binDecrypt($str, $key) : decrypts string without base64
 *     setCsLength($length) : sets CS2 N
 *     getCsLength($length) : returns CS2 N
 *
 * Example:
 *   $ccs = &new ctlCipherSaber();
 *   // should produce 'U1w'Kn':
 *   echo $ccs->binDecrypt('1234567890abcdef', 'xyz');
 **/

class CryptComponent extends Object
{

  public $r; // random number or 10byte key
  public $csl; // (CSL) CS N length for CS2

	public function beforeFilter ()	{	}
	
	public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}

	public function beforeRedirect(Controller $controller){
	}
    
	public function beforeRender(Controller $controller){
	}

  /**
   * Constructor
   *
   * @access public
   * @param CipherSaber2 length (defaults to 1 == CS1)
   **/
  public function ctlCipherSaber($csl = 1) // defaults to CS1
  {
    $this->csl = $csl;
  }

  /**
   * set CS2 length
   *
   * @access public
   * @param $length - integer length value
   **/
  public function setCsLength($length)
  {
    $this->csl = $length;
  }

  /**
   * get CS2 length
   *
   * @access public
   * @return integer length value
   **/
  public function getCsLength()
  {
    return $this->csl;
  }

  /**
   * Usual string encrypt with additional base64 encryption
   *
   * @access public
   * @param $str - string to be encrypted
   * @param $key - key/password to be used for encryption
   * @return encrypted and base64 encoded string
   **/
  public function encrypt($str, $key)
  {
    srand((double)microtime()*1234567);
    $this->r = substr(md5(rand(0,32000)),0,10);
    return base64_encode($this->r.$this->_cs($str,$key));
  }

  /**
   * Usual base64 string decrypt
   *
   * @access public
   * @param $str - string (base64 encoded) to be decrypted
   * @param $key - key/password to be used for decryption
   * @return decrypted string
   **/
  public function decrypt($str, $key)
  {
    $str=base64_decode($str);
    $this->r = substr($str,0,10);
    $str=substr($str,10);
    return $this->_cs($str, $key);
  }

  /**
   * Encrypt without base64
   *
   * @access public
   * @param $str - string to be encrypted
   * @param $key - key/password to be used for encryption
   * @return encrypted string
   **/
  public function binEncrypt($str,$key)
  {
    srand((double)microtime()*1234567);
    $this->r = substr(md5(rand(0,32000)),0,10);
    return $this->r.$this->_cs($str,$key);
  }

  /**
   * Decrypt without base64
   *
   * @access public
   * @param $str - string to be decrypted
   * @param $key - key/password to be used for decryption
   * @return decrypted string
   **/
  public function binDecrypt($str,$key)
  {
    $this->r = substr($str,0,10);
    $str=substr($str,10);
    return $this->_cs($str,$key);
  }


  /**
   * CipherSaber algorithm
   *
   * @access private
   * @param $d - string
   * @param $p - key
     * @return encrypted/decrypted string
     **/
  public function _cs($d, $p)
  {
    $k = $this->r;
    $p .= $k;

    for ($i=0; $i < 256; $i++)
          $S[$i] = $i;

    $j = 0;
    $t = strlen($p);

    for ($i=0; $i < 256; $i++)
    {
      $K[$i] = ord(substr($p,$j,1));
      $j = ($j + 1) % $t;
    }

    $j=0;
    for ($kk=0; $kk < $this->csl; $kk++) // this loop gives CS2 functionality
    {
      for ($i = 0; $i < 256; $i++)
      {
        $j = ($j + $S[$i] + $K[$i]) & 0xff;
        $t = $S[$i];
        $S[$i] = $S[$j];
        $S[$j] = $t;
      }
    }

    $i=0;
    $j=0;
    $ii=0;
    $ret = '';

    $dlen = strlen($d);
    for ($ii=0; $ii < $dlen; $ii++)
    {
      $c=$d{$ii};
      $i = ($i + 1) & 0xff;
      $j = ($j + $S[$i]) & 0xff;
      $t = $S[$i];
      $S[$i] = $S[$j];
      $S[$j] = $t;
      $t = ($S[$i] + $S[$j]) & 0xff;
      $ret .= chr($S[$t]) ^ $c;
    }

    return $ret;
  }
}