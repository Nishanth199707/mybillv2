// document.querySelector('.action-print').addEventListener('click', function(event) {
//   event.preventDefault();
//   /* Act on the event */
//   window.print();
// });
document.querySelector('.action-print').addEventListener('click', function(event) {
  event.preventDefault();

  // Optional: Apply specific styles or modifications before printing
  document.body.classList.add('print-mode'); // Example of toggling a print class

  // Delay printing slightly to ensure the DOM is ready
  setTimeout(() => {
    window.print();
    document.body.classList.remove('print-mode'); // Cleanup after printing
  }, 100); // Adjust delay as needed
});
