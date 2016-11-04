
var uniq = 'WQJL3D1oTHaEQjW0oNpPnA';

"<style>." + uniq + " {
  border: 1px solid silver;
  display: inline-block;
}</style>";

var btn = document.createElement('span');
btn.className = uniq;
btn.innerHTML = 'Get info';
btn.onclick = function() {
  getInfo(btn, TBD);
}
TBD.appendChild(btn);

'<span class="' + uniq + '">Get info</span>';
