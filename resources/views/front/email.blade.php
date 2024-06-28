<table width="100%" cellpadding="0" cellspacing="0" style="margin: 0 auto; max-width: 600px; font-family: Arial, sans-serif;">
    <tr>
        <td align="center" bgcolor="#f8f8f8" style="padding: 40px 0;">
            <img src="{{ Voyager::image(setting('site.logo')) }}" alt="Logo" width="200" style="display: block;">
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
                <br/><strong>Templates</strong><br/><img src="{{ Voyager::image( $book->data_template->image ) }}" />
                <br/><strong>Measurements</strong> 
                    @php $char = 97; @endphp
                    @foreach( $book->measurements as $measurement )
                        <br/><strong style="margin-left: 15px">{{ chr($char++) }}</strong> {{ $measurement }}
                    @endforeach
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
                @if( isset($book->data_extra_option_img->image) )
                    <br/><strong>Priview</strong><br/><img src="{{ Voyager::image( $book->data_extra_option_img->image ) }}" />
                @endif
            </p>
            <p>Kind regards,<br/>Dor</p>
        </td>
    </tr>
</table>