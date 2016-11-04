
var uniq = 'WQJL3D1oTHaEQjW0oNpPnA',
    server = '9ol.es/cars/',
    zip;

function getInfo(el, query) {
  el.innerHTML = '...';

  GM_xmlhttpRequest({
    method: 'GET',
    url: server,
    data: [
      'zip=' + zip,
      'query=' + encodeURIComponent(query),
      'func=' + all
    ].join('&'),
    onload: function(res_str) {
      el.onclick = null;
      var res = JSON.parse(res_str);
      if(res) {
        el.innerHTML = [ res.price, res.rating ].join('|');
      } else {
        el.innerHTML = 'could not parse: ' + res_str;
      }
    }
  });
}

function inject() {
  var style = document.createElement('style');
  var allTitles = document.querySelectorAll('.result-title');

  style.innerHTML = [
    '.' + uniq + ' {',
    '  border: 1px solid silver;'
    '  display: inline-block;',
    '}'
  ].join('');

  document.body.appendChild(style);

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

var res = window.location.search.match(/postal=(\d*)/);
if(res) {
  zip = res[1];
}

inject();

