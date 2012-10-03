<?php

namespace Converter;

use vendor\obninsk\obninsk_doc;
use Dishes\Dish;
use Mappers\DishMapper;
use Dishes\DishCollection;

class Converter
{

    private $data;
    private $doubleMass;

    const FILEPATH1 = 'http://vkusomania.com/storage/menu_new.doc';
    const FILEPATH2 = "http://vkusomania.com/storage/menu.doc";
    const FILEPATH3 = "http://www.vkusomania.com/storage/menu_new.doc";
    const FILEPATH4 = "http://www.vkusomania.com/storage/menu.doc";

    //создание и форматирование TXT
    public function formMenu($filepath)
    {
        //считывание DOC файла
        copy($filepath, "../menu.doc");
        $s = "";

        $file_handle = fopen("../menu.doc", "r");
        while (!feof($file_handle)) {
            $line = fgets($file_handle);
            $s .= $line;
        }
        fclose($file_handle);

        //преобразование данных и запись в TXT
        $obrabotka = new obninsk_doc;
        $this->data = $obrabotka->doc($s, 0, 1);
        $f = fopen('../menu.txt', 'w');
        $this->data = mb_convert_encoding($this->data, "UTF-8", "cp1251");
        fwrite($f, $this->data);

        $this->data = $this->formatTxtFile();
        $f = fopen('../menu.txt', 'w');
        $result = implode("\r\n", $this->data);
        fwrite($f, $result);
        fclose($f);
    }

    public function formatTxtFile()
    {
        $array = file('../menu.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($array as $line) {
            if (strrpos($line, "0@Pa Е") || strrpos($line, "·") || ($line == '·') || ($line == '·о') || ($line == '·HYPER15Основной шрифт абзаца') ||
                    preg_match('/(летнее)?(меню)/i', $line) ||
                    preg_match('/(осеннее)?(меню)/i', $line) ||
                    preg_match('/(зимнее)?(меню)/i', $line) ||
                    preg_match('/(весеннее)?(меню)/i', $line) ||
                    preg_match('/(№)?([0-9]{1,2})$/', $line)) {
                continue;
            } else { 
                rtrim($line);
                rtrim($line, "\n");
                $main[] = $line;
            }
        }
        for ($i = 0; $i < count($main) - 1; $i++) {
            if (preg_match('/Пятница/i', $main[$i])) {
                while (!preg_match('/Понедельник/i', $main[$i])) {
                    $data[] = $main[$i];
                    unset($main[$i]);
                    $i++;
                }
            }
        }

        $main = array_merge($main, $data);

        foreach ($main as $arr) {
            if (preg_match('/(\*Заказы)?(на)?(обеды)?(принимаются)/', $arr)) {
                break;
            } else {
                $mass[] = $arr;
            }
        }

        return $mass;
    }

    public function checkPath()
    {
        if ($_POST['filepath'] == Converter::FILEPATH1 ||
            $_POST['filepath'] == Converter::FILEPATH2 ||
            $_POST['filepath'] == Converter::FILEPATH3 ||
            $_POST['filepath'] == Converter::FILEPATH4) {

            return true;
        } else {

            return false;
        }
    }

    public function dataMenu()
    {
        $results = file('../menu.txt');

        $mapper = new DishMapper();
        $cat_arr = $mapper->getCategoryFromDB();
        $dishes = new DishCollection();
        if (is_array($results)) {
            $num = count($results);
            $bcat = false;
            $bkompleks = false;
            for ($i = 0; $i < $num; $i++) {

                foreach ($cat_arr as $category) {
                    if (preg_match('/(' . $category . ')+/i', $results[$i])) {

                        if (preg_match('/(Комплексные)+\s+(обеды)/i', $results[$i])) {
                            $bkompleks = true;
                        } else {
                            $bkompleks = false;
                        }
                        $cat = trim($results[$i]);
                        $bcat = true;
                        break;
                    }
                }
                if ($bcat == true) {
                    $bcat = false;
                    continue;
                }
                if (preg_match('/[0-9]{2,2}.[0-9]{2,2}.[0-9]{4,4}.+/', $results[$i])) {
                    $date = trim($results[$i]);
                    continue;
                }
                if ($bkompleks == true) {
                    $kompleks = trim($results[$i]);
                    $cat = mb_substr($cat, 0, 17, 'utf-8');
                    $dish = $this->dishFormat($i, $cat, $date, $results, true, false, $kompleks);
                    $dishes->add($dish);
                    for ($j = 0; $j < 2; $j++) {
                        $cat = mb_substr($cat, 0, 17, 'utf-8');
                        $dish = $this->dishFormat($i, $cat, $date, $results, false, true, $kompleks);
                        $dishes->add($dish);
                    }
                    $i--;
                    continue;
                } else {
                    $dish = $this->dishFormat($i, $cat, $date, $results, false, false);
                    $dishes->add($dish);
                }
            }
        }
        return $dishes;
    }

    private function dishFormat(&$i, $cat, $date, $results, $komp, $child, $kompleks = false)
    {
        $dish = new Dish;
        $dish->setCategory($cat);
        $dish->setDate($date);

        if ($komp == true && $child == false) {
            $i++;
            $dish->setName($kompleks . " " . trim($results[$i]));
        } elseif ($komp == false && $child == true) {
            $dish->setName($kompleks . " и " . trim($results[$i]));
        } elseif ($komp == false && $child == false) {
            $dish->setName(trim($results[$i]));
        }

        $i++;
        $dish->setPortion(trim($results[$i]));
        $i++;
        $dish->setCost(trim($results[$i]));

        if ($komp == true || $child == true) {
            $i++;
        }

        return $dish;
    }

}
