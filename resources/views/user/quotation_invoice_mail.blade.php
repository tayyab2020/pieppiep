<html>

<body>

@if($type == 'new')

    <p>
        Hi Nordin Adoui,<br><br>Recent activity: A quotation <b>(QUO# {{$quotation_invoice_number}})</b> has been created by Mr./Mrs. <b>{{$username}}</b> against quotation request # <b>({{$quote_number}})</b>. PDF file is attached below. Quotation is waiting for your approval.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte
    </p>

@elseif($type == 'edit')

    <p>
        Hi Nordin Adoui,<br><br>Recent activity: A quotation <b>(QUO# {{$quotation_invoice_number}})</b> has been edited by Mr./Mrs. <b>{{$username}}</b> due to client review request against quotation request # <b>({{$quote_number}})</b>. PDF file is attached below.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte
    </p>

@elseif($type == 'edit client')

    <p>
        Hi {{$client}},<br><br>Recent activity: A quotation <b>(QUO# {{$quotation_invoice_number}})</b> has been edited by Mr./Mrs. <b>{{$username}}</b> due to your review request against quotation request # <b>({{$quote_number}})</b>. PDF file is attached below.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte
    </p>

@elseif($type == 'invoice client')

    <p>
        Hi {{$client}},<br><br>Recent activity: An Invoice <b>(INV# {{$quotation_invoice_number}})</b> has been generated against your quotation request # <b>({{$quote_number}})</b> by Mr./Mrs. <b>{{$username}}</b>. PDF file is attached below.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte
    </p>

@elseif($type == 'invoice')

    <p>
        Hi Nordin Adoui,<br><br>Recent activity: An Invoice <b>(INV# {{$quotation_invoice_number}})</b> has been generated against quotation request # <b>({{$quote_number}})</b> by Mr./Mrs. <b>{{$username}}</b>. PDF file is attached below.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte
    </p>

@endif

</body>

</html>
