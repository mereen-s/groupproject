// Live patient search using the browser's native fetch (AJAX, no libraries - TC-01)
function attachPatientSearch(inputId, resultsId, openPage) {
  var input = document.getElementById(inputId);
  var box = document.getElementById(resultsId);
  if (!input || !box) return;
  var t = null;
  input.addEventListener('input', function () {
    clearTimeout(t);
    var q = input.value.trim();
    if (q.length < 2) { box.innerHTML = ''; return; }
    t = setTimeout(function () {
      fetch('index.php?page=api_patient_search&q=' + encodeURIComponent(q))
        .then(function (r) { return r.json(); })
        .then(function (rows) {
          var html = '<table><tr><th>ID</th><th>Name</th><th>NIC</th><th></th></tr>';
          rows.forEach(function (p) {
            html += '<tr><td><b>' + p.patient_id + '</b></td><td>' + p.name + '</td><td>' + (p.nic || '') + '</td>' +
              '<td><a class="btn secondary" href="index.php?page=' + openPage + '&pid=' + p.patient_id + '">Open</a></td></tr>';
          });
          box.innerHTML = html + '</table>';
        });
    }, 250);
  });
}
