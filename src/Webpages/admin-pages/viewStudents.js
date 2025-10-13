function ajaxSearch() {
  var input = document.getElementById("searchInput").value;
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "view-students.php?search=" + encodeURIComponent(input), true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      document.getElementById("studentTableBody").innerHTML = xhr.responseText;
      // Hide pagination when searching
      var pagination = document.querySelector('.pagination');
      if (pagination) {
        pagination.style.display = input.trim() ? 'none' : '';
      }
    }
  }  
  xhr.send();
};
document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("searchInput").addEventListener("keyup", ajaxSearch);
});

