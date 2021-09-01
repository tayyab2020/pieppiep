<html>

<body>

@if($type == 'new')

    {{--<p>
        Hi {{$client}},<br><br>You have received a quotation <b>(QUO# {{$quotation_invoice_number}})</b> by Mr./Mrs. <b>{{$username}}</b>. PDF file is attached below. Quotation is waiting for your approval.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte
    </p>--}}

    <p>
        Beste {{$client}},<br><br>Je hebt een nieuwe offerte ontvangen <b>(QUO# {{$quotation_invoice_number}})</b>. Zie bijlage voor de offerte.<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> {{$company_name}}
    </p>

@elseif($type == 'edit client')

    {{--<p>
        Hi {{$client}},<br><br>Recent activity: Updates have been made to quotation <b>(QUO# {{$quotation_invoice_number}})</b> by Mr./Mrs. <b>{{$username}}</b>. PDF file is attached below.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte
    </p>--}}

    <p>
        Beste {{$client}},<br><br>Je hebt een nieuwe offerte ontvangen <b>(QUO# {{$quotation_invoice_number}})</b>. Zie bijlage voor de offerte.<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> {{$company_name}}
    </p>

@elseif($type == 'invoice client')

    {{--<p>
        Hi {{$client}},<br><br>Recent activity: An Invoice <b>(INV# {{$quotation_invoice_number}})</b> has been generated by Mr./Mrs. <b>{{$username}}</b>. PDF file is attached below.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte
    </p>--}}

    <p>
        Beste {{$client}},<br><br>Je hebt een nieuwe factuur ontvangen <b>(INV# {{$quotation_invoice_number}})</b>. Zie bijlage voor de offerte.<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> {{$company_name}}
    </p>

@elseif($type == 'direct-invoice')

    {{--<p>
        Hi {{$client}},<br><br>Recent activity: A Direct Invoice <b>(INV# {{$quotation_invoice_number}})</b> has been generated by Mr./Mrs. <b>{{$username}}</b>. PDF file is attached below.<br><br>Kind regards,<br><br>Klantenservice<br><br> Vloerofferte
    </p>--}}

    <p>
        Beste {{$client}},<br><br>Je hebt een nieuwe factuur ontvangen <b>(INV# {{$quotation_invoice_number}})</b>. Zie bijlage voor de offerte.<br><br>Met vriendelijke groeten,<br><br>Klantenservice<br><br> {{$company_name}}
    </p>

@elseif($type == 'new-quotation')

    <p>
        Hi {{$supplier}},<br><br>Recent activity: A new order <b>({{$order_number}})</b> has been received by <b>{{$company_name}}</b>. PDF file is attached below.<br><br>Kind regards,<br><br>Klantenservice<br><br> Pieppiep
    </p>

@endif

</body>

</html>
