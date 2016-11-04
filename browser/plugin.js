
var uniq = 'WQJL3D1oTHaEQjW0oNpPnA';

"<style>


function getInfo(el, data) {
}

function inject() {
  var style = document.createElement('style');
  style.innerHTML = [
    '.' + uniq + ' {',
    '  border: 1px solid silver;'
    '  display: inline-block;',
    '}'
  ].implode('');
  document.body.appendChild(style);

  var allTitles = document.querySelectorAll('.result-title');

  allTitles.forEach(function(what) {
    var 
      title = what.innerHTML,
      btn = document.createElement('span'),
      container = what.parentNode;

    btn.className = uniq;
    btn.innerHTML = 'Get info';
    btn.onclick = function() {
      getInfo(btn, title);
    }
    container.appendChild(btn);
  });
}

inject();

