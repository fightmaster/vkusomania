<?php
namespace Models;
use vendor\obninsk\obninsk_doc;
use Dishes\Dish;
use Mappers\DishMapper;
class Model {
 
	private $data;
	private $doubleMass;
	private $mail;

	//создание и форматирование TXT
	function calculate($filepath) 
	{
			//считывание DOC файла
			copy($filepath,"../menu.doc");
			$s="";   

			$file_handle = fopen("../menu.doc", "r");
			while (!feof($file_handle)) {
			$line = fgets($file_handle);
			$s .= $line;
			}
			fclose($file_handle);

			
			//преобразование данных и запись в TXT
			$obrabotka = new obninsk_doc;
			$this->data= $obrabotka->doc($s,0,1);
			$f = fopen('../menu.txt', 'w');
			$this->data = mb_convert_encoding( $this->data, "UTF-8", "cp1251");
			fwrite($f, $this->data);
			
			//фильтрация от лишних символов, пустых строк, значений
			//перестановка пятницы в конец файла
			$this->data = $this->massive();
			$f = fopen('../menu.txt', 'w');
			$result=implode("\r\n",$this->data);
			fwrite($f,$result);
			fclose($f);

	}
	
	//фильтрация лишних символов и перенос пятницы в конец файла
    function massive()
    {
			$array = file('../menu.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
			foreach ($array as $line){
				if (strrpos($line, "0@Pa Е") || preg_match('/(·)/',   $line) ||
									preg_match('/(летнее)?(меню)/i',   $line) || 
									preg_match('/(осеннее)?(меню)/i',  $line) || 
									preg_match('/(зимнее)?(меню)/i',   $line) ||
									preg_match('/(весеннее)?(меню)/i', $line) ||
									preg_match('/(№)?([0-9]{1,2})$/',  $line)) {
					continue;
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
			foreach ($main as $arr){
				if (preg_match('/(\*Заказы)?(на)?(обеды)?(принимаются)/', $arr)){
					break;	
				} else {
					$mass[] = $arr;
				}
			}
		
			return $mass;
    }

	//вывод полного варианта меню
	function GetMenuFromTXT()
	{
			//вывод меню
			$array = file('../menu.txt');
			return $array;
	}
	//вывод меню с текущего дня
	
	function CheckPath()
	{
			if ( $_POST['filepath'] == 'http://vkusomania.com/storage/menu.doc'     || 
			     $_POST['filepath'] == 'http://vkusomania.com/storage/menu_new.doc' ||
				 $_POST['filepath'] == 'http://www.vkusomania.com/storage/menu.doc'     || 
			     $_POST['filepath'] == 'http://www.vkusomania.com/storage/menu_new.doc' ){

				return true;
			} else {
				return false;
			}
	
	}
	//формирование таблиц, внешнего вида меню
	function DataMenu() 
	{
			$results = file('../menu.txt');

			$mapper = new DishMapper();
			$cat_arr = $mapper->GetCategoryFromDB();
			if (is_array($results)){
			$num = count($results);
			$bcat = false;
			$bkompleks = false;
					for ($i=0;$i<$num;$i++){
					
						foreach ($cat_arr as $category){
							if (preg_match('/('.$category.')+/i', $results[$i])){
								
								if ( preg_match('/(Комплексные)+\s+(обеды)/i', $results[$i])){
									$bkompleks = true;
								}else { 
									$bkompleks = false;
								}
								$cat = trim($results[$i]);
								$bcat = true;	
								break;
								
							}
							
						}
						if ($bcat==true){$bcat = false; continue;}
						if (preg_match('/[0-9]{2,2}.[0-9]{2,2}.[0-9]{4,4}.+/', $results[$i])){
							$date = trim($results[$i]);
							continue;
						}
						if ($bkompleks == true){
							$Dish = new Dish;
							$cat = mb_substr($cat,0,17,'utf-8');
							$Dish->setCategory($cat);
							$Dish->setDate($date);
							$kompleks = trim($results[$i]);
							$i++;
							$Dish->setName($kompleks." ".trim($results[$i]));
							$i++;
							$Dish->setPortion(trim($results[$i]));
							$i++;
							$Dish->setCost(trim($results[$i]));
							$i++;
							$Dishes[]=$Dish;
							for ($j=0;$j<2;$j++){
								$Dish = new Dish;
								$cat = mb_substr($cat,0,17,'utf-8');
								$Dish->setCategory($cat);
								$Dish->setDate($date);
								$Dish->setName($kompleks." и ".trim($results[$i]));
								$i++;
								$Dish->setPortion(trim($results[$i]));
								$i++;
								$Dish->setCost(trim($results[$i]));
								$i++;
								$Dishes[]=$Dish;
							}
							$i--;
							continue;
						}else{
							$Dish = new Dish;
							$Dish->setCategory($cat);
							$Dish->setDate($date);
							$Dish->setName(trim($results[$i]));
							$i++;
							$Dish->setPortion(trim($results[$i]));
							$i++;
							$Dish->setCost(trim($results[$i]));
							$Dishes[]=$Dish;
						}
					}
			}
			return $Dishes;
    }

	//отправка письма 
	function sendmail($send)
	{
			mail('svyatoslav_maslov@mail.ru','Заказы обедов ВкусоМания',$send);
	}

} // class Model
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />