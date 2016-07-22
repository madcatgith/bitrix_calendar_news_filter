<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<table id="calendar2">
  <thead>
    <tr><td>‹<td colspan="5"><td>›
    <tr><td>Пн<td>Вт<td>Ср<td>Чт<td>Пт<td>Сб<td>Вс
  <tbody>
</table>

<script>
function Calendar2(id, year, month) {

var filter = 'arrFilter'; //Переменная для фильтра, указываеться в настройках фильтра и newlist. Служить для связи листа и фильтра.

var Dlast = new Date(year,month+1,0).getDate(),
    D = new Date(year,month,Dlast),
    currmonth = month+1,
    DNlast = new Date(D.getFullYear(),D.getMonth(),Dlast).getDay(),
    DNfirst = new Date(D.getFullYear(),D.getMonth(),1).getDay(),
    calendar = '<tr>',
    month=["Январь","Февраль","Март","Апрель","Май","Июнь","Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь"];
    if (currmonth < 10){
      currmonth='0'+currmonth;
    }
if (DNfirst != 0) {
  for(var  i = 1; i < DNfirst; i++) calendar += '<td>';
}else{
  for(var  i = 0; i < 6; i++) calendar += '<td>';
}

/*Сортировка происходит с помощью указания в запросе начальной и конечной даты активности. 
Чтобы отсортировать по дате за выбранный день нужно указать датой окончания завтрашний.
Дата должна быть вида 01.01.0001*/

for(var  i = 1; i <= Dlast; i++) {

//Формируем строку с датой начала активности
  if (i<10){
     var start_filter_date='0'+i+'.'+currmonth+'.'+year; //добавляем ноль перед датой из одной цифры 
  }
  else{
    var start_filter_date=i+'.'+currmonth+'.'+year;
  }
//
  var end_filter_date=nextday(i,currmonth,year); //строка с датой конца активности (следующий день);

  if (i == new Date().getDate() && D.getFullYear() == new Date().getFullYear() && D.getMonth() == new Date().getMonth()) {
    calendar += '<td class="today">' +'<a href="?'+filter+'_DATE_ACTIVE_FROM_1='+start_filter_date+'&arrFilter_DATE_ACTIVE_FROM_2='+end_filter_date+'&set_filter=Фильтр&set_filter=Y">' + i + '</a>';
  }else{
    calendar += '<td>' +'<a href="?'+filter+'_DATE_ACTIVE_FROM_1='+start_filter_date+'&arrFilter_DATE_ACTIVE_FROM_2='+end_filter_date+'&set_filter=Фильтр&set_filter=Y">' + i + '</a>';
  }
  
  if (new Date(D.getFullYear(),D.getMonth(),i).getDay() == 0) {
    calendar += '<tr>';
  }
}
for(var  i = DNlast; i < 7; i++) calendar += '<td>&nbsp;';
document.querySelector('#'+id+' tbody').innerHTML = calendar;
document.querySelector('#'+id+' thead td:nth-child(2)').innerHTML = month[D.getMonth()] +' '+ D.getFullYear();
document.querySelector('#'+id+' thead td:nth-child(2)').dataset.month = D.getMonth();
document.querySelector('#'+id+' thead td:nth-child(2)').dataset.year = D.getFullYear();
if (document.querySelectorAll('#'+id+' tbody tr').length < 6) {  // чтобы при перелистывании месяцев не "подпрыгивала" вся страница, добавляется ряд пустых клеток. Итог: всегда 6 строк для цифр
    document.querySelector('#'+id+' tbody').innerHTML += '<tr><td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;';
}
}
Calendar2("calendar2", new Date().getFullYear(), new Date().getMonth());
// переключатель минус месяц
document.querySelector('#calendar2 thead tr:nth-child(1) td:nth-child(1)').onclick = function() {
  Calendar2("calendar2", document.querySelector('#calendar2 thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar2 thead td:nth-child(2)').dataset.month)-1);
}
// переключатель плюс месяц
document.querySelector('#calendar2 thead tr:nth-child(1) td:nth-child(3)').onclick = function() {
  Calendar2("calendar2", document.querySelector('#calendar2 thead td:nth-child(2)').dataset.year, parseFloat(document.querySelector('#calendar2 thead td:nth-child(2)').dataset.month)+1);
}

//Функция получает месяц дату день и возвращает завтрашний день в виде 02.01.0001
function nextday(day,month,year){
  var y = parseInt(year);
  var m = parseInt(month)-1;
  var d = parseInt(day);
  var tommorow = new Date(y,m,d+1);
  d=tommorow.getDate();
  m=tommorow.getMonth()+1;
  y=tommorow.getFullYear();
  if (d < 10){
    d='0'+d;
  }
  if (m < 10){
    m='0'+m;
  }
  return d+'.'+m+'.'+y;
}
</script>
