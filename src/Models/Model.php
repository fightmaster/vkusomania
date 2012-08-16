<?php
namespace Models;
use vendor\obninsk\obninsk_doc;
class Model {
 
	private $data;
	private $doubleMass;
	private $mail;

	function calculate($filepath) 
	{
			copy($filepath,"../menu.doc");

			$s="";     
			$fp = fopen("../menu.doc",'rb');    

			while (($fp != false) && !feof($fp)){
				$s.=fread($fp,filesize("../menu.doc")); 
			} 
			
			fclose($fp);
			$obrabotka = new obninsk_doc;
			$this->data= $obrabotka->doc($s,0,1);
			$f = fopen('../menu.txt', 'w');
			fwrite($f, $this->data);
			
			$this->data = $this->massive();
			$str = $this->displayResults($this->data);
			
			$f = fopen('../menu.txt', 'w');
			fwrite($f, $str);
			fclose($f);
	}
	
	static function fullMenu()
	{
			$fp = fopen("../menu.txt",'rb');    
			while (($fp != false) && !feof($fp)){
				$s.=fread($fp,filesize("../menu.txt")); 
			}            
			fclose($fp);
			
			if( stristr( $s ,date("d.m.Y") ) ){
				return $s;
			} else {
				return $s = "<h2>Вы загружаете устаревшее меню!</h2>";
			}
	}
	    
	static function showDate()
	{
	
			$array = file('../menu.txt');
			$bool = false;
			for ($i=0;$i<(count($array)-1);$i++){
			
					if( stristr( $array[$i] ,date("d.m.Y") ) ){
						$bool = true;
						for ($j=$i;$j<(count($array)-1);$j++){
							$str .= $array[$j];
						}
					break;				
					}
			}
			
			if ($bool==false){
				$str = false;
			}
			return $str;
	}
	
    function massive()
    {
			$array = file('../menu.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
				
			foreach ($array as $line){
				if ($line=="·" or  strrpos($line, "0@Pa Е")) {
					break;
				} else {
					rtrim($line);
					rtrim($line, "\n");
					$main[] = $line;
				}
			}
				
			for ($i=0; $i<count($main)-1; $i++){
				if ( preg_match('/Пятница/i',$main[$i]) ) {
					while ( !preg_match('/Понедельник/i',   $main[$i]) ){
						$data[] = $main[$i];
						unset($main[$i]);
						$i++;
					}
				}
			}
			
			$main = array_merge ($main, $data);
			return $main;
    }
	
	function displayResults($results) 
	{
            if (is_array($results)){
				$num = 1;
				$main='';
                for ($i=0; $i<count($results)-1; $i++){

                    if( preg_match('/(летнее)?(меню)/i',   $results[$i]) || 
                        preg_match('/(осеннее)?(меню)/i',  $results[$i]) || 
                        preg_match('/(зимнее)?(меню)/i',   $results[$i]) ||
                        preg_match('/(весеннее)?(меню)/i', $results[$i]) ) {
						
							$day = $results[$i-1];
							$main .= "<br><span id='day' >".$results[$i-1]."</span><br>\r\n";
							$main .= "<span id='season' >".$results[$i]."</span><br>\r\n";
                        
                    } elseif ( $results[$i] == 'Салаты') {
			
                        $main .= "<br><span id='category' >".$results[$i]."</span><br>\r\n";
						$main .= "<table border>";
						$main .= '<tr><td>№</td><td>Наименование:</td>'
							.'<td>Кол-во:</td><td>Цена:</td>'
							.'<td>Кол-во шт:</td></tr>';
						$food = $results[$i];			
						$i++;
									
						while ( $results[$i]!='Первые блюда' ) {
							if ( preg_match('/(№)?([0-9]{1,2})$/', $results[$i]) ) { 
								$str = $results[$i];
								$main .= "<tr><td>".$results[$i]."</td>";
								$i++;
								$str .='||'.$results[$i];
								$main .= "<td>".$results[$i]."</td>";
								$i++;
								$str .='||'.$results[$i];
								$main .= "<td>".$results[$i]."</td>";
								$i++;
								$str .='||'.$results[$i];
								$main .= "<td>".$results[$i]."</td>";
								$i++;
								$main .= "<td id='kol'> <input size='2' type='text' name=$num value='' > </td></tr>";
								$info =$day.'||'.$food.'||'.$str;
								$main .= "<input type='hidden' name='a.$num' value='$info'>";
								$num++;
							} else {
								break 1;
							}
											
						}
						$main .= "</table>\r\n"; 
					} elseif ( $results[$i-1] == 'Первые блюда') {
						$food = $results[$i-1];           
						$main .= "<br><span id='category' >".$results[$i-1]."</span><br>\r\n";
						$main .= "<table border>";
						$main .= '<tr><td>№</td><td>Наименование:</td>'
							.'<td>Кол-во:</td><td>Цена:</td>'
							.'<td>Кол-во шт:</td></tr>';	
							
						while ( $results[$i]!=='Вторые блюда' ) {		
							if ( preg_match('/(№)?([0-9]{1,2})$/', $results[$i]) ) { 
								$str = $results[$i];
							    $main .= "<tr><td>".$results[$i]."</td>";
							    $i++;
							    $str .='||'.$results[$i];
							    $main .= "<td>".$results[$i]."</td>";
							    $i++;
							    $str .='||'.$results[$i];
							    $main .= "<td>".$results[$i]."</td>";
							    $i++;
  		 					    $str .='||'.$results[$i];
							    $main .= "<td>".$results[$i]."</td>";
							    $i++;
							    $main .= "<td id='kol'> <input size='2' type='text' name='$num' value='' > </td></tr>";
							    $info =$day.'||'.$food.'||'.$str;
							    $main .= "<input type='hidden' name='a.$num' value='$info'>";
							    $num++;

					        } else {	   
								break 1; 
							}
															
						}				
						$main .= "</table>\r\n";
                        
					} elseif ( $results[$i-1] == 'Вторые блюда') {
                        $food = $results[$i-1];
                        $main .= "<br><span id='category' >".$results[$i-1]."</span><br>\r\n";
                        $main .= "<table border>";
						$main .= '<tr><td>№</td><td>Наименование:</td>'
							.'<td>Кол-во:</td><td>Цена:</td>'
							.'<td>Кол-во шт:</td></tr>';
											
							while ( !preg_match('/^(Комплексные)?(обеды)^/i', $results[$i]) ) {
							
								if ( preg_match('/(№)?([0-9]{1,2})$/', $results[$i]) ){    
									$str = $results[$i];
									$main .= "<tr><td>".$results[$i]."</td>";
									$i++;
									$str .='||'.$results[$i];
									$main .= "<td>".$results[$i]."</td>";
									$i++;
									$str .='||'.$results[$i];
									$main .= "<td>".$results[$i]."</td>";
									$i++;
									$str .='||'.$results[$i];
									$main .= "<td>".$results[$i]."</td>";
									$i++;
									$main .= "<td id='kol'> <input size='2' type='text' name='$num' value='' > </td></tr>";
									$info =$day.'||'.$food.'||'.$str;
									$main .= "<input type='hidden' name='a.$num' value='$info'>";
									$num++;
								} else {
									break 1;
								}					
							}
										
							$main .= "</table>\r\n";
                        
					} elseif ( preg_match('/(Комплексные)+\s+(обеды)/i', $results[$i-1])) {
						$food = $results[$i-1];
                        $main .= "<br><span id='category' >".$results[$i-1]."</span><br>\r\n";
                        $main .= "<table border>";
						$main .= '<tr><td>№</td><td>Наименование:</td><td>Гарнир:</td>'
							.'<td>Кол-во:</td><td>Цена:</td>'
							.'<td>Кол-во шт:</td></tr>';
							
							while ( !preg_match("/([0-9]{2}).([0-9]{2}).([0-9]{4})./", $results[$i]) ){
								if ( preg_match('/(№)?([0-9]{1,2})$/', $results[$i]) ){    
									$str = $results[$i];
									$main .= "<tr><td>".$results[$i]."</td>";
									$i++;
									$str .= '||'.$results[$i].' ';
									$n_main = $results[$i];
									$main .= "<td rowspan=3>".$results[$i]."</td>";
									$i++;
									$str .= $results[$i];
									$main .= "<td>".$results[$i]."</td>";
									$i++;
									$str .= '||'.$results[$i];
									$main .= "<td>".$results[$i]."</td>";
									$i++;
									$str .= '||'.$results[$i];
									$main .= "<td>".$results[$i]."</td>";
									$i++;
									$info =$day.'||'.$food.'||'.$str;
									$main .= "<td id='kol'> <input size='2' type='text' name=$num value='' > </td></tr>";
									$main .= "<input type='hidden' name='a.$num' value='$info'>";
									$num++;
									
										for ($j=1; $j<3; $j++) {
											if ( preg_match('/(№)?([0-9]{1,2})$/', $results[$i]) ){    
												$str = $results[$i];
												$main .= "<tr><td>".$results[$i]."</td>";
												$i++;
												$str .='||'.$n_main.' и '.$results[$i];
												$main .= "<td>".$results[$i]."</td>";
												$i++;
												$str .='||'.$results[$i];
												$main .= "<td>".$results[$i]."</td>";
												$i++;
												$str .='||'.$results[$i];
												$main .= "<td>".$results[$i]."</td>";
												$i++;
												$main .= "<td id='kol'> <input size='2'  type='text' name=$num value='' > </td></tr>";
												$info =$day.'||'.$food.'||'.$str;
												$main .= "<input type='hidden' name='a.$num' value='$info'>";
												$num++;
											} else {   
												break 1; 
											}  
										}
								} else {   
									break 1;
								}											
							}								
							$main .= "</table>\r\n";					
					}
                }
				
				$main .= "<br><br></div><input class='add_comment' id='comment' type='submit' name='order' value='Заказать'>\r\n";
				$main .= "</form>";
				
            } else {    
				echo $results;
            }
			
		return $main;
    }
	 
	function orderDetail($mass)
	{
			$it=(count($mass)-2)/2;
			$ordernum = 1;
			
			$this->doubleMass[person][0] = $mass['FIO'];
			
			for ($i=1; $i<=$it; $i++){
				if ( !empty($_POST[$i]) ){
					$StrArr = explode("||",$mass[a_.$i]);
					$StrArr[] = $mass[$i];
					
					for ($j=0;$j<7;$j++){
						$this->doubleMass[$ordernum][$j] = $StrArr[$j];
					}
					
					$itogo += $this->doubleMass[$ordernum][5]*$this->doubleMass[$ordernum][6];
					$ordernum++;
				}	
			}
			
			$this->doubleMass[itog][0] = $itogo;
			$mailText  = 'ФИО заказчика: '.$this->doubleMass[person][0]."!\n";
			$mailText .= "Список блюд:\n\n";
				
			$num = count($this->doubleMass)-2;
				
			for ($i=1;$i<=$num;$i++){
				$mailText .= $i.")";
				
				for ($j=0;$j<7;$j++){
					if ($j == 6){
						$mailText .=$this->doubleMass[$i][$j]." шт. \n";
					} else {
						$mailText .=$this->doubleMass[$i][$j]."\n";
					}
					 
				}
				
				$mailText .= "\n";	
			}
			
			$mailText .= "Итого: ".$this->doubleMass[itog][0]." руб.";
			$this->mail = $mailText;
	}

	
	
	function sendmail($send)
	{
			mail ('svyatoslav_maslov@mail.ru','Заказы обедов ВкусоМания',$send);
	}
	
	function getData() 
	{
			if ($this->data) {
				return $this->data;
			} else {
				return 'Ошибка считывания DOC файла!';
			}
	}
	
	function getDoubleMass() 
	{
			if ($this->doubleMass) {
				return $this->doubleMass;
			} else {
				return 'Ошибка! Заказ не сформирован.';
			}
	}
	
    function getMail() 
	{
			if ($this->mail) {
				return $this->mail;
			} else {
				return 'Ошибка! Письмо не сгенерированно.';
			}
	}

} // class Model
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />