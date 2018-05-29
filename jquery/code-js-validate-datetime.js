function isValidDate(dateString) {
  var regEx = /^\d{4}\/\d{2}\/\d{2}$/;
  if(!dateString.match(regEx)) return false;  // Invalid format
  var d = new Date(dateString);
  if(!d.getTime() && d.getTime() !== 0) return false; // Invalid date
  return (d.getFullYear()+'/'+(d.getMonth()+1)+'/'+(d.getDate())) === dateString;
}