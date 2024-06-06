<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['dayGrid'],
    events: [
    <?php
    // Fetch bookings
    $currentDateTime = date('Y-m-d H:i:s');
                $query = mysqli_query($conn, "SELECT * FROM bookings WHERE email = '$res_Email' AND date > '$currentDateTime'");
    while($row = mysqli_fetch_assoc($query)) {
        $service = $row['service'];
    $date = $row['date'];
    $details = $row['details'];
    echo "{title: '$service', date: '$date', description: '$details' },";
                }

    // Fetch website events
    $currentDateTime = date('Y-m-d H:i:s');
                $query = mysqli_query($conn, "SELECT * FROM events WHERE event_type = 'website' AND event_date > '$currentDateTime'");
    while($row = mysqli_fetch_assoc($query)) {
        $eventName = $row['event_name'];
    $eventDate = $row['event_date'];
    $eventDetails = $row['event_details'];
    echo "{title: '$eventName', date: '$eventDate', description: '$eventDetails' },";
                }
                ?>
    ],
    eventClick: function(info) {
        alert('Event: ' + info.event.title + '\nDate: ' + info.event.start.toISOString() + '\nDetails: ' + info.event.extendedProps.description);
            }
        });
    calendar.render();
    });
</script>