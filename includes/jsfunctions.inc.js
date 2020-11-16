
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
  textbox.name = 'maara';
  textbox.id = "maara" + counter;
  document.getElementById('TextBoxDiv' + counter).appendChild(label);
  newTextBoxDiv.appendChild(textbox);
  

  var selectList= document.createElement('select');
  selectList.id = 'yksikko' + counter;
  selectList.name = 'yksikko';
  document.getElementById('TextBoxDiv' + counter).appendChild(selectList);
  
  var raw = window.data;
  var clean = [];
  for (var i = 0, len = raw.length; i < len; i++) {
      clean.push(raw[i].nimi);
  }

  for (var i = 0; i<clean.length; i++){
    var option = document.createElement('option');
    option.value = i;
    option.text = clean[i];
    selectList.appendChild(option);
  }


  var label, textbox;

  label = document.createElement('label');
  label.appendChild(document.createTextNode('Ainesosa #' + counter));
  textbox = document.createElement('input');
  textbox.type = 'textainesosa';
  textbox.name = 'ainesosa';
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