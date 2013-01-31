<?php 
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Copyright (c) 2011 VamSoft Ltd.
   License - http://vamcart.com/license.html
   ---------------------------------------------------------------------------------------*/

class SummaComponent extends Object 
{

	public function beforeFilter ()
	{
	}

	public function initialize(Controller $controller) {
	}
    
	public function startup(Controller $controller) {
	}

	public function shutdown(Controller $controller) {
	}

	public function beforeRender(Controller $controller){
	}
	
	public function beforeRedirect(Controller $controller){
	}
	
public $diw=Array(    0 =>    Array(    0  => Array( 0=> "ноль",    1=>1), 
                1  => Array( 0=> "",        1=>2), 
                2  => Array( 0=> "",        1=>3), 
                3  => Array( 0=> "три",        1=>0), 
                4  => Array( 0=> "четыре",    1=>0), 
                5  => Array( 0=> "пять",    1=>1), 
                6  => Array( 0=> "шесть",    1=>1), 
                7  => Array( 0=> "семь",    1=>1), 
                8  => Array( 0=> "восемь",    1=>1), 
                9  => Array( 0=> "девять",    1=>1), 
                10 => Array( 0=> "десять",    1=>1), 
                11 => Array( 0=> "одинадцать",    1=>1), 
                12 => Array( 0=> "двенадцать",    1=>1), 
                13 => Array( 0=> "тринадцать",    1=>1), 
                14 => Array( 0=> "четырнадцать",1=>1), 
                15 => Array( 0=> "пятнадцать",    1=>1), 
                16 => Array( 0=> "шестнадцать",    1=>1), 
                17 => Array( 0=> "семнадцать",    1=>1), 
                18 => Array( 0=> "восемнадцать",1=>1), 
                19 => Array( 0=> "девятнадцать",1=>1) 
            ), 
        1 =>    Array(    2  => Array( 0=> "двадцать",    1=>1), 
                3  => Array( 0=> "тридцать",    1=>1), 
                4  => Array( 0=> "сорок",    1=>1), 
                5  => Array( 0=> "пятьдесят",    1=>1), 
                6  => Array( 0=> "шестьдесят",    1=>1), 
                7  => Array( 0=> "семьдесят",    1=>1), 
                8  => Array( 0=> "восемьдесят",    1=>1), 
                9  => Array( 0=> "девяносто",    1=>1)  
            ), 
        2 =>    Array(    1  => Array( 0=> "сто",        1=>1), 
                2  => Array( 0=> "двести",    1=>1), 
                3  => Array( 0=> "триста",    1=>1), 
                4  => Array( 0=> "четыреста",    1=>1), 
                5  => Array( 0=> "пятьсот",    1=>1), 
                6  => Array( 0=> "шестьсот",    1=>1), 
                7  => Array( 0=> "семьсот",    1=>1), 
                8  => Array( 0=> "восемьсот",    1=>1), 
                9  => Array( 0=> "девятьсот",    1=>1) 
            ) 
); 

public $nom=Array(    0 => Array(0=>"копейки",  1=>"копеек",    2=>"одна копейка", 3=>"две копейки"), 
        1 => Array(0=>"рубля",    1=>"рублей",    2=>"один рубль",   3=>"два рубля"), 
        2 => Array(0=>"тысячи",   1=>"тысяч",     2=>"одна тысяча",  3=>"две тысячи"), 
        3 => Array(0=>"миллиона", 1=>"миллионов", 2=>"один миллион", 3=>"два миллиона"), 
        4 => Array(0=>"миллиарда",1=>"миллиардов",2=>"один миллиард",3=>"два миллиарда"), 
/* :))) */ 
        5 => Array(0=>"триллиона",1=>"триллионов",2=>"один триллион",3=>"два триллиона") 
); 

public $out_rub; 

public function get($summ){ 
 if($summ>=1) $this->out_rub=0; 
 else $this->out_rub=1; 
 $summ_rub= doubleval(sprintf("%0.0f",$summ)); 
 if(($summ_rub-$summ)>0) $summ_rub--; 
 $summ_kop= doubleval(sprintf("%0.2f",$summ-$summ_rub))*100; 
 $kop=$this->get_string($summ_kop,0); 
 $retval=""; 
 for($i=1;$i<6&&$summ_rub>=1;$i++): 
  $summ_tmp=$summ_rub/1000; 
  $summ_part=doubleval(sprintf("%0.3f",$summ_tmp-intval($summ_tmp)))*1000; 
  $summ_rub= doubleval(sprintf("%0.0f",$summ_tmp)); 
  if(($summ_rub-$summ_tmp)>0) $summ_rub--; 
  $retval=$this->get_string($summ_part,$i)." ".$retval; 
 endfor; 
 if(($this->out_rub)==0) $retval.=" рублей"; 
 return $retval." ".$kop; 
} 

public function get_string($summ,$nominal){ 
 $retval=""; 
 $nom=-1; 
 $summ=round($summ); 
 if(($nominal==0&&$summ<100)||($nominal>0&&$nominal<6&&$summ<1000)): 
  $s2=intval($summ/100); 
  if($s2>0): 
   $retval.=" ".$this->diw[2][$s2][0]; 
   $nom=$this->diw[2][$s2][1]; 
  endif; 
  $sx=doubleval(sprintf("%0.0f",$summ-$s2*100)); 
  if(($sx-($summ-$s2*100))>0) $sx--; 
  if(($sx<20&&$sx>0)||($sx==0&&$nominal==0)): 
   $retval.=" ".$this->diw[0][$sx][0]; 
   $nom=$this->diw[0][$sx][1]; 
  else: 
   $s1=doubleval(sprintf("%0.0f",$sx/10)); 
   if(($s1-$sx/10)>0)$s1--; 
   $s0=doubleval($summ-$s2*100-$s1*10); 
   if($s1>0): 
    $retval.=" ".$this->diw[1][$s1][0]; 
    $nom=$this->diw[1][$s1][1]; 
   endif; 
   if($s0>0): 
    $retval.=" ".$this->diw[0][$s0][0]; 
    $nom=$this->diw[0][$s0][1]; 
   endif; 
  endif; 
 endif; 
 if($nom>=0): 
  $retval.=" ".$this->nom[$nominal][$nom]; 
  if($nominal==1) $this->out_rub=1; 
 endif; 
 return trim($retval); 
} 

}
?>