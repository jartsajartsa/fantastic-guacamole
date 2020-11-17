
function topnav() {
  var x = document.getElementById("nav");
  if (x.className === "header_nav") {
    x.className += " responsive";
  } else {
    x.className = "header_nav";
  }
}


$(document).ready(function(){

  var counter = 2;
      
  $("#addButton").click(function () {
              
  if(counter>30){
          alert("Kenttiä ei voi lisätä enempää");
          return false;
  }   
      
  var newTextBoxDiv = document.createElement('div');
      newTextBoxDiv.id = ('TextBoxDiv' + counter);
      document.getElementById('ainekset').appendChild(newTextBoxDiv);
 

  var label, textbox;

  label = document.createElement('label');
  label.appendChild(document.createTextNode('Määrä #' + counter));
  textbox = document.createElement('input');
  textbox.type = 'textbox';
  textbox.name = 'ainekset[aines' + counter + '][maara]';
  textbox.id = "maara" + counter;
  document.getElementById('TextBoxDiv' + counter).appendChild(label);
  newTextBoxDiv.appendChild(textbox);
  

  var selectList= document.createElement('select');
  selectList.id = 'yksikko' + counter;
  selectList.name = 'ainekset[aines' + counter + '][yksikko]';
  document.getElementById('TextBoxDiv' + counter).appendChild(selectList);
  
 
  for (var i = 0; i<options.length; i++){
    var option = document.createElement('option');
    option.value = i;
    option.text = options[i];
    selectList.appendChild(option);
  }

  var label, textbox;

  label = document.createElement('label');
  label.appendChild(document.createTextNode('Ainesosa #' + counter));
  textbox = document.createElement('input');
  textbox.type = 'textainesosa';
  textbox.name = 'ainekset[aines' + counter + '][ainesosa]';
  textbox.id = "ainesosa" + counter;
  document.getElementById('TextBoxDiv' + counter).appendChild(label); 
  newTextBoxDiv.appendChild(textbox);
   
              
  counter++;
});

    $("#removeButton").click(function () {
  if(counter==1){
        alert("Ei poistettavia rivejä");
        return false;
      }   
      
  counter--;
          
    $("#TextBoxDiv" + counter).remove();
          
    });
});