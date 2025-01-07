document.querySelector('.contenttopdf').addEventListener('click', function(event) {
    event.preventDefault();

    const element = document.getElementById('ct');

    // Add any custom styles if needed
    const customStyle = `
           <style>
        .invoice-container1 {
            width: 100%;
            /* Make container full width */
            max-width: 800px;
            /* Optional: set a maximum width */
            margin: auto;
            /* Center-align the container */
            border: 1px solid rgb(0, 0, 0);
            padding: 20px;
            margin-top: 2px;
            box-sizing: border-box;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table th,
        .table td {
            border: 0.5pt solid #303030;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 25%;
        }

        .table th:nth-child(2),
        .table td:nth-child(2) {
            width: 15%;
        }


        .t3,
        th,
        td {
            /* border: 0.5pt solid #303030; */
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            vertical-align: top
        }

        body {
            /* border: 0.5pt solid #303030; */
            border-collapse: collapse;
            word-wrap: break-word;
            font-family: 'sans-serif', 'Arial';
            font-size: 11px;
            /*height: 210mm;*/
        }




        .row1 {
            display: flex;
            border-top: none;
        }

        .row2 {
            display: flex;

        }

        .col-md-6 {
            display: flex;
            flex-direction: column;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            padding: 20px;
            border-top: 1px solid #ddd;
            /* Optional, for visual separation */
        }
    </style>
    `;

    // Create a temporary container to apply the custom style
    const tempContainer = document.createElement('div');
    tempContainer.innerHTML = customStyle + element.innerHTML;

    html2pdf()
        .from(tempContainer)
        .set({
            margin: 10,
            filename: 'download.pdf',
            html2canvas: {
                scale: 2,
                useCORS: true,
                letterRendering: true
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        })
        .save();
});
