<table width="100%" cellpadding="0" cellspacing="0" style="margin: 0 auto; max-width: 600px; font-family: Arial, sans-serif;">
    <tr>
        <td align="center" bgcolor="#f8f8f8" style="padding: 40px 0;">
            <img src="{{ url('/') }}/front/images/logo.png" alt="Logo" width="200" style="display: block;">
        </td>
    </tr>
    <tr>
        <td bgcolor="#f8f8f8" style="padding: 40px 30px;">

            <p>Dear {{$book->name}},</p>
            <p> Thank you for your request at dor.<p>
            <p> We will get back to you regarding your request within one working day.</p>
            <p>We have received the following information from you:</p>
            <p>
                <strong>Style</strong> {{$book->data_style->name}}
                <br/><strong>Door Type</strong> {{$book->data_door_type->name}}
                {{-- <br/><strong>Templates</strong> {{$book->data_template->name}} --}}
                {{-- <br/><strong>Measurements</strong> {{$book->measurements}} --}}
                <br/><strong>Glass Thickness</strong> {{$book->data_thickness->name}}
                <br/><strong>Glass Type</strong> {{$book->data_glass_type->name}}
                <br/><strong>Hardware Finish</strong> {{$book->data_hardware->name}}
                <br/><strong>Handle</strong> {{$book->data_handle->name}}
                <br/><strong>Name</strong> {{$book->name}}
                <br/><strong>Address</strong> {{$book->address}}
                <br/><strong>Phone</strong> {{$book->phone}}
                <br/><strong>City</strong> {{$book->city}}
                <br/><strong>Email</strong> {{$book->email}}
                <br/><strong>Zip</strong> {{$book->zip}}
                <br/><strong>Comments</strong> {{$book->comments}}
                {{-- <br/><strong>Priview</strong> {{$book->name}} --}}
            </p>
            <p>Kind regards,<br/>Together on 30</p>
        </td>
    </tr>
</table>