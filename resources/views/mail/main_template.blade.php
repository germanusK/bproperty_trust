<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>b-property_trust notification</title>
        <style>
            body{
                display: flex;
                align-items: center;
                vertical-align: middle;
                justify-content: center;
            }
            .box{
                width: 70%;
                min-width: 10rem;
                margin: auto;
                border-radius: 1rem;
                justify-content: center;
                text-align: center;
                padding: 2rem 3rem;
                border-bottom: 1px solid rgb(32, 0, 32);
            }
            .subject{
                width: fit-content;
                font-size: large;
                font-weight: 500;
                color: rgb(0, 0, 41);
                margin: 0.5rem auto;
            }
            hr{
                width: 90%;
                /* background: lightgoldenrodyellow;
                border-color: lightgoldenrodyellow; */
            }
            .message{
                width: fit-content;
                font-size: large;
                font-weight: normal;
                color: #333;
                margin: 0.2rem auto;
            }
            .caption{
                text-align: center;
                font-size: smaller;
                font-weight: lighter;
                color: rgb(32, 0, 32);
            }
        </style>
    </head>
    <body>
        <div class="box">
            @if(isset($data->heading))
            <div class="subject">{{  $data->heading : "Mail Heading" }}</div>
            @else
            <div class="subject">Mail Heading</div>
            @endif
            <hr>
            @if(isset($data->message))
            <div class="message"> {{ $data->message }} </div>
            @else
            <div class="message">Message body content</div>
            @endif
        </div>
        <div class="caption">bproperty_trust.com; your leading property provider.</div>
    </body>
</html>