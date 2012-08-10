<?php
namespace Views;

class View {
 
	static function displayDefault() 
	{
            echo "<form method='POST' action='index.php' > ";
            echo "Введите адрес ссылки меню DOC-файла с http://www.vkusomania.com/site/menu.html :<br><br>";
            echo "<input type='text' size='65' name='filepath' value='' > ";
            echo "<input type='submit' name='send' value='Отправить'>";
            echo "</form>";
	}
	
	static function getOrder($doubleMass,$message) 
	{
			echo 'Уважаемый '.$doubleMass[person][0].'!<br><br>';
            echo 'Вы заказали:<br><br>';
			echo '<table border>';
			echo '<tr><td>Дата:</td><td>Категория:</td><td>№</td>'
				.'<td>Наименование:</td><td>Кол-во</td><td>Цена:</td>'
				.'<td>Кол-во шт.:</td></tr>';
				
			for ($i=1;$i<=count($doubleMass)-2;$i++){
				
				echo '<tr>';
				for ($j=0;$j<7;$j++){
				    echo '<td>'.$doubleMass[$i][$j].'</td>';
				}
				echo '</tr>';	
			}
			
			echo '</table>';
			echo "<br>Итого: ".$doubleMass[itog][0].' руб.';
			echo "<form method='POST' action='index.php' ><br>";
			echo "<input type='submit' name='confirm' value='Подтвердить'>";
			echo "<input type='hidden' name='zakaz' value='$message'>";
            echo "</form>";
	}
 

	static function displayError($error) 
	{
            echo "<b>Ошибка:</b> {$error}<br>";
			echo "<a href='http://localhost/vkusomania/web/index.php'>Вернуться назад</a>";
	}
	
	static function Send() 
	{
            echo "<b>Спасибо!</b><br>";
			echo "<b>Ваш заказ отправлен.</b><br>";
			echo "<a href='http://localhost/vkusomania/web/index.php'>Вернуться на главную...</a>";
	}

 
	static function displayResults($results) 
	{
            if (is_array($results)){
            
				echo "<form method='POST' action='index.php' > ";
				echo "Введите ФИО:<br>";
				echo "<input type='text' name='FIO' value=''><br>";
				$num = 1;
			
                for ($i=0; $i<count($results)-1; $i++){

                    if( preg_match('/(летнее)?(меню)/i',   $results[$i]) || 
                        preg_match('/(осеннее)?(меню)/i',  $results[$i]) || 
                        preg_match('/(зимнее)?(меню)/i',   $results[$i]) ||
                        preg_match('/(весеннее)?(меню)/i', $results[$i]) ) {
						
							$day = $results[$i-1];
							echo "<br><span id='day' >".$results[$i-1]."</span><br>";
							echo "<span id='season' >".$results[$i]."</span><br>";
                        
                    } elseif ( $results[$i] == 'Салаты') {
			
                        echo "<br><span id='category' >".$results[$i]."</span><br>";
						echo "<table border>";
						echo '<tr><td>№</td><td>Наименование:</td>'
							.'<td>Кол-во:</td><td>Цена:</td>'
							.'<td>Кол-во шт.:</td></tr>';
						$food = $results[$i];			
						$i++;
									
						while ( $results[$i]!='Первые блюда' ) {
							if ( preg_match('/(№)?([0-9]{1,2})$/', $results[$i]) ) { 
								$str = $results[$i];
								echo "<tr><td>".$results[$i]."</td>";
								$i++;
								$str .='||'.$results[$i];
								echo "<td>".$results[$i]."</td>";
								$i++;
								$str .='||'.$results[$i];
								echo "<td>".$results[$i]."</td>";
								$i++;
								$str .='||'.$results[$i];
								echo "<td>".$results[$i]."</td>";
								$i++;
								echo "<td id='kol'> <input size='2' type='text' name=$num value='' > </td></tr>";
								$info =$day.'||'.$food.'||'.$str;
								echo "<input type='hidden' name='a.$num' value='$info'>";
								$num++;
							} else {
								break 1;
							}
											
						}
						echo "</table>"; 
					} elseif ( $results[$i-1] == 'Первые блюда') {
						$food = $results[$i-1];           
						echo "<br><span id='category' >".$results[$i-1]."</span><br>";
						echo "<table border>";
						echo '<tr><td>№</td><td>Наименование:</td>'
							.'<td>Кол-во:</td><td>Цена:</td>'
							.'<td>Кол-во шт.:</td></tr>';	
							
						while ( $results[$i]!=='Вторые блюда' ) {		
							if ( preg_match('/(№)?([0-9]{1,2})$/', $results[$i]) ) { 
								$str = $results[$i];
							    echo "<tr><td>".$results[$i]."</td>";
							    $i++;
							    $str .='||'.$results[$i];
							    echo "<td>".$results[$i]."</td>";
							    $i++;
							    $str .='||'.$results[$i];
							    echo "<td>".$results[$i]."</td>";
							    $i++;
  		 					    $str .='||'.$results[$i];
							    echo "<td>".$results[$i]."</td>";
							    $i++;
							    echo "<td id='kol'> <input size='2' type='text' name='$num' value='' > </td></tr>";
							    $info =$day.'||'.$food.'||'.$str;
							    echo "<input type='hidden' name='a.$num' value='$info'>";
							    $num++;

					        } else {	   
								break 1; 
							}
															
						}				
						echo "</table>";
                        
					} elseif ( $results[$i-1] == 'Вторые блюда') {
                        $food = $results[$i-1];
                        echo "<br><span id='category' >".$results[$i-1]."</span><br>";
                        echo "<table border>";
						echo '<tr><td>№</td><td>Наименование:</td>'
							.'<td>Кол-во:</td><td>Цена:</td>'
							.'<td>Кол-во шт.:</td></tr>';
											
							while ( !preg_match('/^(Комплексные)?(обеды)^/i', $results[$i]) ) {
							
								if ( preg_match('/(№)?([0-9]{1,2})$/', $results[$i]) ){    
									$str = $results[$i];
									echo "<tr><td>".$results[$i]."</td>";
									$i++;
									$str .='||'.$results[$i];
									echo "<td>".$results[$i]."</td>";
									$i++;
									$str .='||'.$results[$i];
									echo "<td>".$results[$i]."</td>";
									$i++;
									$str .='||'.$results[$i];
									echo "<td>".$results[$i]."</td>";
									$i++;
									echo "<td id='kol'> <input size='2' type='text' name='$num' value='' > </td></tr>";
									$info =$day.'||'.$food.'||'.$str;
									echo "<input type='hidden' name='a.$num' value='$info'>";
									$num++;
								} else {
									break 1;
								}					
							}
										
							echo "</table>";
                        
					} elseif ( preg_match('/(Комплексные)+\s+(обеды)/i', $results[$i-1])) {
						$food = $results[$i-1];
                        echo "<br><span id='category' >".$results[$i-1]."</span><br>";
                        echo "<table border>";
						echo '<tr><td>№</td><td>Наименование:</td><td>Гарнир:</td>'
							.'<td>Кол-во:</td><td>Цена:</td>'
							.'<td>Кол-во шт.:</td></tr>';
							
							while ( !preg_match("/([0-9]{2}).([0-9]{2}).([0-9]{4})./", $results[$i]) ){
								if ( preg_match('/(№)?([0-9]{1,2})$/', $results[$i]) ){    
									$str = $results[$i];
									echo "<tr><td>".$results[$i]."</td>";
									$i++;
									$str .= '||'.$results[$i].' ';
									$n_main = $results[$i];
									echo "<td rowspan=3>".$results[$i]."</td>";
									$i++;
									$str .= $results[$i];
									echo "<td>".$results[$i]."</td>";
									$i++;
									$str .= '||'.$results[$i];
									echo "<td>".$results[$i]."</td>";
									$i++;
									$str .= '||'.$results[$i];
									echo "<td>".$results[$i]."</td>";
									$i++;
									$info =$day.'||'.$food.'||'.$str;
									echo "<td id='kol'> <input size='2' type='text' name=$num value='' > </td></tr>";
									echo "<input type='hidden' name='a.$num' value='$info'>";
									$num++;
									
										for ($j=1; $j<3; $j++) {
											if ( preg_match('/(№)?([0-9]{1,2})$/', $results[$i]) ){    
												$str = $results[$i];
												echo "<tr><td>".$results[$i]."</td>";
												$i++;
												$str .='||'.$n_main.' и '.$results[$i];
												echo "<td>".$results[$i]."</td>";
												$i++;
												$str .='||'.$results[$i];
												echo "<td>".$results[$i]."</td>";
												$i++;
												$str .='||'.$results[$i];
												echo "<td>".$results[$i]."</td>";
												$i++;
												echo "<td id='kol'> <input size='2'  type='text' name=$num value='' > </td></tr>";
												$info =$day.'||'.$food.'||'.$str;
												echo "<input type='hidden' name='a.$num' value='$info'>";
												$num++;
											} else {   
												break 1; 
											}  
										}
								} else {   
									break 1;
								}											
							}								
							echo "</table>";					
					}
                }
				
				echo "<br><br><input type='submit' name='order' value='Заказать'>";
				echo "</form>";
            } else {    
				echo $results;
            }
    }
 
} // class VIEW
?>
