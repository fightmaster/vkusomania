<?php
namespace vendor\obninsk
{
/** (En) ***********************************************************************
 *                            obninsk_doc.php
 *   Obninsk is the first science-city of Russia and it is a city, where lives
 *   Max Brown, the author of this program, extracting a text from .doc files
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 * 
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details: <http://www.gnu.org/licenses/gpl.txt>
 *   
 *   You may freely use and/or modify this program for non-commercial purposes
 *   if you leave this notification unchanged.
 *   For commercial purposes, You may use this program, but may not modify it.
 *   This program inserts sometimes in the default mode a reference to vendor
 *   and i ask you to do not remove this feature wuthout placing at your site
 *   a hyperlink to the program homepage http://obninsk.name/obninsk_doc/
 * 
	*   Updates: added Ukrainian language support, by Krezalis (www.ek-you.org.ua)
 ***************************************************************************/
 
 /** (RUS) ******************************************************************
 *	Obninsk_doc v.1.0.alpha 
 * ���� ������, ������������� ��������� MS Word � �����, ������� � 50-����� 
 * ������� ����������� ���������� �������� - ������, � ������� ���� 
 * � ������� �������� �������� ����� ������� ���� ����� (http://obninsk.name/mx/)
 * ��� ������ ������� �� ��������� ��������� �����-���� ��������� Micro$oft,
 * ���������� �������� PHP, ��� ����� �� ������������ �������� �� �� �������.
 * 
 * ����������� ���������� ������������� ������� ��� � ��������������,
 * ��� � � ������������ ����� ��� ������� ���������� ���������� ������� �����.
 * ��������� ������� ����� ����������� ������ ��� ������������� � �������������� 
 * ����� � ������ ��� ������� ���������� � �� ������� ���������� �����������. 
	*
	* UPD: Krezalis (www.ek-you.org.ua) ������� ��������� �����������, ������� ���.
 * 
 * ���������� �� ���������:
 * ������ ��������� ���� obninsk_doc � ����� ���������� ������ �����.
 * 
 ***************************************************************************/
 
 /***************************************************************************
 *
 * ���������� �� �������������:
 * 1. ����� ������ ���������� � ������� obninsk.doc() �������� � ���������� 
 * � ������ �������: require_once("obninsk_doc.php");
 * 1.� ���� ������� ���������� ��������, ������������ �� ������ ����������,
 * ��� ������� ����� ��������� ���: require_once("����\obninsk_doc.php"); ,
 * ��� ���� - ��� ���� � �����, � ������� �� ����������� ������ ������������
 * ��� �����, �� ������� ���������� ��� ������, ������������ obninsk_doc
 * ��������: require_once("../includes/obninsk_doc.php");
 *
 * 2. ������� ������ ������ �������: $text_content=obninsk_doc($doc_file);
 * ����� ������ ������ ������ ������� obninsk_doc() � ��������� �������� 
 * �������������� ���������� ������ ��������� � ����� example.php 
 * 
 * ������ obninsk_doc ����� ������������������ � ������� ����� ���������� ������
 * � �����������, ����������� �� ��� ���� �������.
 * � ������ ������ 1.0.alpha ������ ����� ������������ �����, ���������� ������:
 * ���������� �����
 * ����������� M$ Word
 * ������� ������� M$ Word
 * ������� ������� (�� ���������� ������ ���������) ��������
 *
 * ����� ����� ������, ������� ��������� ������������ ������ ������� M$ Word, 
 * ����� �� ����������� �������� ������� �� ������:
 * http://obninsk.name/obninsk_doc/
 * 
 * ��������! ��� �����-������ � ��� ������������ ��� �����-���� ��������
 * ����� �� ���� ������� ��������������� �� ��������� �����������
 * ������������� ���� ������� ���� ������������� ��� ������������.
 * 
 ***************************************************************************/
class obninsk_doc {

function doc($doc, $html=1, $cont=1){
$c20=(int)(hexdec("20"));
$c00=(int)(hexdec("00"));
$br=($html)?"<br />":"\r\n";
$c_AA=(int)hexdec("10");
$c_a=(int)hexdec("30");
$bugcnt=0;
$SPACE='000000';
$START='00d9'.$SPACE;

 $txt = '';
	$dec_AA=hexdec("10");
	$dec_a=hexdec("30");
 $sz=strlen($doc)*2;
 $hex=bin2hex($doc);
	for ($i=0; $i<strlen($hex); $i+=4) {
  $j=(int)($i/4);
		$c1=substr($hex,$i,2);
		$c2=substr($hex,$i+2,2);
		$hex1[$j]=(int)(hexdec($c1));
		$hex2[$j]=(int)(hexdec($c2));
		if ($c2=='00'){
			if ($c1!='0d') $c=chr(hexdec($c1));
			else $c = "\r\n";
		} //if
		elseif($c2=='04'){
			$cdec=hexdec($c1);
			if($cdec>$dec_a) $c=chr($cdec-$dec_a+ord('�'));
			else $c=chr($cdec-$dec_AA+ord('�'));
		} //if
		else $c='';
 } //for
	$startpos=$this->obninsk_doc_detect_start($hex1, $hex2);
	$endpos=$this->obninsk_doc_detect_end($startpos, $hex1, $hex2);
	$s1=substr($hex, (4*$startpos), (4*113) );
	$i=$startpos;
	$sz=sizeof($hex1);
	while($i<$endpos){	 
		$c1=$hex1[$i];
		$c2=$hex2[$i];
		$c="";
		if( $c1 + $c2 == 0 ) {
 	 if(!$cont) break;  else {$i=$this->obninsk_doc_detect_start($hex1, $hex2, $i); continue;} //if
 	} //if
// 	debug("\$c1=[".dechex($c1)."]; \$c2=[".dechex($c2)."]");
		if($c2==0x20) {
 		if($c1==0x13) $c="�"; // ������� ����
 		elseif($c1==0x19) $c="�"; // ��������
			elseif($c1==0x1c) $c=chr(147); 
   elseif($c1==0x1d) $c=chr(148); // ������� �����
   elseif($c1==0x1e) $c=chr(132); // ����� �����
		}
		elseif($c2==0x21) {
   if($c1==0x16) $c="�"; // �����
   elseif($c1==0x22) $c=chr(153); // ������� �����		
		}
 	elseif ($c2==0){
 		$c=chr($c1);
 		if ($c1==0x0d){ // New Line
 			$c = "\r\n";
 			if($html) $c=$br;
 		} //if New Line
 		if ($c1==0x2c) { }// ����
 		if ($c1==0x2D) {$c="-";}
 		if ($c1==0x0f) {$i=$endpos; break;} //Crop Img tag 
 		if ($c1==0x08) {$c="";} // Cut some null symbol
 		if ($c1==0x07) {$c=$br;} //Replace table symbol
 		if ($c1==0x13) {$c="HYPER13";} // For HYPERLINK processing
 		if ($c1==0x01) {$c="";} 
 		if ($c1==0x14) {$c="HYPER14";} 
 		if ($c1==0x15) {$c="HYPER15";} 
 	} 
 	elseif($c2==4){
 		if($c1>$c_a) { 
    $c=chr($c1-$c_a+ord('�'));
    if($c1==81)$c='�';
    if($c1==86)$c='�';
    if($c1==87)$c='�';
    if($c1==84)$c='�';
    if($c1==144)$c='�';
    if($c1==145)$c='�';
   } else { 
    $c=chr($c1-$c_AA+ord('�'));
    if($c1==1)$c='�';
    if($c1==6)$c='�';
    if($c1==7)$c='�';
    if($c1==4)$c='�';
   } // else !($c1>$c_a)
 } // elseif cyrillic char
 	else{
	 	$c=chr($c1).chr($c2);
	 	if (  ( $c == "��" )  ||  ( ($c1=0x22) && ($c2=0x20) )  )  $c=($html)?"<br>�":"\r\n�";
	 } //else two one-byte chars
// 	debug("\$c1=[".dechex($c1)."]; \$c2=[".dechex($c2)."]; c=[".htmlspecialchars($c)."]");
	 $i++;
	 $txt=$txt.$c;
 }
	if ($html){
		$txt=preg_replace("/HYPER13 *HTMLCONTROL(.*)HYPER15/iU", "", $txt);
		$txt=preg_replace("/HYPER13 *INCLUDEPICTURE *\"(.*)\".*HYPER14(.*)HYPER15/iU", "<img src=\"\\1\" border=0 />", $txt);
		$txt=preg_replace("/HYPER13 *HYPERLINK *\"(.*)\".*HYPER14(.*)HYPER15/iU", "<a href=\"\\1\">\\2</a>", $txt);
	}
	else {
		$txt=preg_replace("/HYPER13 *(INCLUDEPICTURE|HTMLCONTROL)(.*)HYPER15/iU", "", $txt);
		$txt=preg_replace("/HYPER13(.*)HYPER14(.*)HYPER15/iU", "\\2", $txt);
	} // while
 return $txt;
} // function obninsk_doc($doc, $html=1, $cont=1)

function obninsk_doc_detect_start($hex1, $hex2, $startpos=0){
 $sz=sizeof($hex1); 
 for($i=$startpos; $i<$sz; $i++) {
  if( ($hex1[$i]==0x20) && ($hex2[$i]==0) ) {
   if( ($hex2[$i+1]!=0x00) && ($hex2[$i+1]!=0x04) ) continue;
   if( ($hex2[$i-1]!=0x00) && ($hex2[$i-1]!=0x04) ) continue;
   if( ($hex2[$i-1]==0x00) && ($hex1[$i-1]==0x00) ) continue;
   while(  ( $hex1[$i] + $hex2[$i] != 0 )  &&  ( ($hex2[$i]==0) || ($hex2[$i]==4) )  )  $i--;
   if( ($hex1[$i]==0xff) && ($hex2[$i]==0xff) ) return $sz;
   $i++;
   return $i;
  }
 }
 return $sz;
} // function obninsk_doc_detect_start($hex1, $hex2, $startpos=0)

function obninsk_doc_detect_end($startpos, $hex1, $hex2){
$sz=sizeof($hex1);
 for($i=$startpos; $i<$sz; $i++) {
 	$nullcount=0;
 	$ffcount=0;
 	while( ($hex1[$i]==0) && ($hex2[$i] == 0 ) ) {$nullcount++; $i++; if($i>=$sz) continue;}
 	while( ($hex1[$i]==0xff) && ($hex2[$i] == 0xff) ) {$ffcount++; $i++; if($i>=$sz) continue;}
	if ($nullcount>15000) return ($i-$nullcount);
	if ($ffcount>100) return ($i-$ffcount);
 }
 return $sz;
} //function obninsk_doc_detect_end($startpos, $hex1, $hex2)

}
}
?>
