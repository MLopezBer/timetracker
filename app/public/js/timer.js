var interval;
let hours = 0;
let minutes = 0;
let seconds = 0;


$(document.body).on("click", '#startTimer', function(){
    const eventName = $.trim($('#eventName').val());
    if(eventName === "")
    {
        alert("Debes introducir un nombre válido para tu tarea");
        return;
    }

    $.ajax({
        url : '/startTimer',
        method : 'POST',
        data : {
            label: eventName
        },
        success : function (data) {
            if(data.success)
            {
                clearTimer();
                if(data.data===true) startTimer("-");
                else startTimer(JSON.parse(data.data));
            }
            else
            {
                if(data.error===1) alert("El temporizador ya está activo");
            }
        }
    })
});


$(document.body).on("click", '#stopTimer', function(){
    $.ajax({
        url : '/stopTimer',
        method : 'POST',
        success : function (data) {
            if(data.success) stopTimer();
        }
    })
});

function startTimer(time)
{
    if(time !== "-")
    {
        seconds = parseInt(time.seconds);
        minutes = parseInt(time.minutes);
        hours = parseInt(time.hours);

        $('#seconds').html(time.seconds);
        $('#minutes').html(time.minutes);
        $('#hours').html(time.hours);
    }

    interval = setInterval(function() {
        addOne();
    }, 1000);
}

function stopTimer()
{
    clearInterval(interval);
}

function clearTimer()
{
    clearInterval(interval);
    hours = 0;
    minutes = 0;
    seconds = 0;
    $('#seconds').html('00');
    $('#minutes').html('00');
    $('#hours').html('00');
}

function addOne()
{
    let secondsHTML;
    let minutesHTML;
    let hoursHTML;

    seconds = seconds+1;
    if(seconds===60)
    {
        seconds = 0;
        minutes=minutes+1;
        if (minutes===60)
        {
            minutes = 0;
            hours = hours+1;
        }
    }

    if(seconds<10) secondsHTML = '0'+seconds;
    else secondsHTML = seconds;

    if(minutes<10) minutesHTML = '0'+minutes;
    else minutesHTML = minutes;

    if(hours<10) hoursHTML = '0'+hours;
    else hoursHTML = hours;

    $('#seconds').html(secondsHTML);
    $('#minutes').html(minutesHTML);
    $('#hours').html(hoursHTML);
}