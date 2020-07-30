
//document.addEventListener("DOMContentLoaded", () => {
let modal = document.querySelector('.modalwin');
let dark = document.getElementById('shadow');
    let form_wrap = document.querySelector('#div_form');
let searchbox = document.querySelector('.search');
let input = searchbox.children[0];
let searchLbl = searchbox.children[1];
let searchCls = searchbox.children[4];

document.fonts.ready.then(function () {
	form_wrap.style.opacity = 1;
})

//-----------------------NEW SEARCHBOX----------------------------//

form_wrap.addEventListener('mouseover', () => {
	form_wrap.classList.add('formover') });

let out = ('mouseout', () => { 
	form_wrap.classList.remove('formover');
});
form_wrap.addEventListener('mouseout', out);

let focusInp = () => {
searchLbl.style.display = "none";
form_wrap.removeEventListener('mouseout', out);	
console.log('get the func!'); }
let creatStyle = () => {
	var link = document.createElement("link");
	link.type = "text/css";
	link.rel = "stylesheet";
	link.href = '/search_box/css/style.css';
	document.head.appendChild(link); }
input.addEventListener('focus', focusInp);
input.addEventListener('focus', creatStyle, {once:true});

input.addEventListener('blur', () => {
  input.value = ''; searchLbl.style.display = "block" });
	
	let close = ('click', () => {
		form_wrap.classList.remove('formover');
		form_wrap.classList.remove('form-wrap-active');
		//input.value = '';
		//searchbox.blur();
	form_wrap.addEventListener('mouseout', out); 
searchCls.classList.remove('visible');
modal.classList.remove('modalwin_active');
  result.style.display = "none";
  dark.style.display = "none";
  searchLbl.style.display = "block";
  $('body').css("overflow-y", "auto");
});
dark.addEventListener ('click', close);

searchCls.addEventListener ('click', () => {
	input.value = ''; input.focus() });

searchCls.addEventListener('mousedown', e => {
  e.preventDefault() });

let result = document.querySelector('ul#results');

document.addEventListener('submit', e => {
e.preventDefault() });

	function search() {
		var query_value = $('input#input').val();
		if(query_value !== ''){
			$.ajax({
				type: "POST",
				url: "/search_box/search_db.php",
				data: { query: query_value },
				cache: false,
				success: function(data){
			 $("ul#results").html(data); 

	var count = 0;
function compareRandom() {
  count++; return Math.random() - 0.5; }

var obj = document.querySelectorAll("#results li");
//obj.toString().replace(/\s{2,}/g, ' ');
var arr = Array.from(obj);
var rand = arr.sort(compareRandom);	
rand.forEach(function (randEl) {
result.appendChild(randEl) });
//$(rand).appendTo($("ul#results"));
                  }
			});
		} return false;    
	}

//---------------------------INPUT----------------------------//
$("input#input").on("keyup", function(e) {

	//input.onkeyup = 

clearTimeout($.data(this, 'timer'));

	var search_string = input.value;

		 if (search_string.trim().length >= 3) {

	$(this).data('timer', setTimeout(search, 200));
 
	 modal.classList.add('modalwin_active');
	 form_wrap.classList.add('form-wrap-active');

	result.style.display = 'block';
	dark.style.display = 'block';
	$( "#results li h2" ).css("color", 'blue');
	searchCls.classList.add('visible');
	$('body').css("overflow-y", "hidden");
       }		
	

	});

 //---------------------------SUBMIT-RESULTS---------------------//

 document.addEventListener("keyup", entr);
function entr() {
let sorry = document.querySelector('.sorry')

	var en = event.which || event.charCode;
	if (en == 13 && sorry == null){

let text_res = document.querySelector('#div_res');
text_res.style.display = "none";

var w = window.open("/search_box/search_res.php");

  w.onload = function() {

var span = this.document.getElementById('target');
span.classList.add("yellow");
span.innerHTML = (`&#171; ${text_res.innerHTML}... &#187;`);
var ul_res = this.document.getElementById('main_res');
ul_res.innerHTML = result.innerHTML;
  }	
	}
		}
//});





	