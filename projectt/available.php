<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Seat Booking</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            color: #333;
            padding: 20px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            font-size: 30px;
            margin-bottom: 20px;
        }

        .bus-card {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #ecf0f1;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .bus-title {
            font-size: 24px;
            font-weight: bold;
            color: #34495e;
        }

        .bus-details {
            margin: 10px 0;
            font-size: 14px;
            color: #7f8c8d;
        }

        /* Flex container for seats */
        .seats {
            display: flex;
            flex-wrap: wrap; /* Allow seats to wrap into rows */
            gap: 5px; /* Set some gap between buttons */
            margin-top: 30px;
        }

        /* For each button */
        .seats button {
            width: 30px;
            height: 30px;
            font-size: 12px; /* Adjusted to make the text smaller */
            color: white;
            background-color: #27ae60;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0; /* Removed any margin */
            padding: 0; /* Removed any padding */
            transition: background-color 0.3s;
        }

        /* Disabled button style (booked seat) */
        .seats button.booked {
            background-color: #e74c3c;
            cursor: not-allowed;
        }

        /* Button hover effect */
        .seats button:hover:not(.booked) {
            background-color: #3498db;
        }

        /* Button active state */
        .seats button:active {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Available Bus Routes</h1>

    <!-- Bus Route Cards -->
    <?php
    // Example bus routes (can be dynamically generated from your database)
    $busRoutes = [
        ['name' => 'Kathmandu -> Pokhara', 'time' => '7:00 AM', 'duration' => '7 Hours', 'routeId' => 1],
        ['name' => 'Kathmandu -> Bhaktapur', 'time' => '8:00 AM', 'duration' => '1 Hour', 'routeId' => 2],
        ['name' => 'Kathmandu -> Chitwan', 'time' => '9:00 AM', 'duration' => '5 Hours', 'routeId' => 3],
        ['name' => 'Kathmandu -> Lumbini', 'time' => '10:00 AM', 'duration' => '9 Hours', 'routeId' => 4],
        ['name' => 'Kathmandu -> Hetauda', 'time' => '11:00 AM', 'duration' => '4 Hours', 'routeId' => 5],
        ['name' => 'Kathmandu -> Itahari', 'time' => '12:00 PM', 'duration' => '8 Hours', 'routeId' => 6],
        ['name' => 'Kathmandu -> Dharan', 'time' => '1:00 PM', 'duration' => '10 Hours', 'routeId' => 7],
    ];

    // Loop to display the bus routes dynamically
    foreach ($busRoutes as $bus) {
        echo '<div class="bus-card" id="route-' . $bus['routeId'] . '">
                <div class="bus-title">' . $bus['name'] . '</div>
                <div class="bus-details">Departure: ' . $bus['time'] . ' | Duration: ' . $bus['duration'] . '</div>
                <a href="ubooking.php?routeId=' . $bus['routeId'] . '"><button class="button" type="button">Book Now</button></a>
                <div class="seats" id="seats-' . $bus['routeId'] . '">
                    <div class="side">
                        <p>Side A (Left)</p>';
        // Odd-numbered buttons for Side A
        for ($i = 1; $i <= 20; $i += 2) {
            echo '<button id="A' . $bus['routeId'] . '-' . $i . '" data-seat="A' . $i . '">' . $i . '</button>';
        }
        echo '</div>
              <div class="side">
                  <p>Side A (Right)</p>';
        // Even-numbered buttons for Side A
        for ($i = 2; $i <= 20; $i += 2) {
            echo '<button id="A' . $bus['routeId'] . '-' . $i . '" data-seat="A' . $i . '">' . $i . '</button>';
        }
        echo '</div>
              </div>
              <div class="seats">
                  <div class="side">
                      <p>Side B (Left)</p>';
        // Odd-numbered buttons for Side B
        for ($i = 1; $i <= 20; $i += 2) {
            echo '<button id="B' . $bus['routeId'] . '-' . $i . '" data-seat="B' . $i . '">' . $i . '</button>';
        }
        echo '</div>
              <div class="side">
                  <p>Side B (Right)</p>';
        // Even-numbered buttons for Side B
        for ($i = 2; $i <= 20; $i += 2) {
            echo '<button id="B' . $bus['routeId'] . '-' . $i . '" data-seat="B' . $i . '">' . $i . '</button>';
        }
        echo '</div>
              </div>
          </div>';
    }
    ?>

</div>

<script>
    // Function to retrieve booked seats from localStorage
    function getBookedSeats(routeId) {
        return JSON.parse(localStorage.getItem('bookedSeats-' + routeId)) || [];
    }

    // Function to store booked seats in localStorage
    function setBookedSeats(routeId, bookedSeats) {
        localStorage.setItem('bookedSeats-' + routeId, JSON.stringify(bookedSeats));
    }

    // JavaScript to handle seat booking for each bus route independently
    document.querySelectorAll('.seats button').forEach(button => {
        button.addEventListener('click', function () {
            const routeId = this.closest('.bus-card').id.split('-')[1]; // Get the route ID dynamically
            const seatId = this.dataset.seat;

            // If the button is already red (booked), do nothing
            if (this.classList.contains('booked')) {
                return;
            }

            // Mark the seat as booked by changing the button color to red
            this.classList.add('booked');
            this.disabled = true;  // Disable the button after booking

            // Get the current list of booked seats for the route
            let bookedSeats = getBookedSeats(routeId);

            // Add the current seat to the booked list
            bookedSeats.push(seatId);

            // Save the updated booked seats to localStorage
            setBookedSeats(routeId, bookedSeats);

            alert('Seat ' + seatId + ' has been booked for Route ' + routeId);
        });
    });

    // Check booked seats for each route on page load
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.bus-card').forEach(card => {
            const routeId = card.id.split('-')[1];
            const bookedSeats = getBookedSeats(routeId);

            bookedSeats.forEach(seatId => {
                const button = document.querySelector('[data-seat="' + seatId + '"]');
                if (button) {
                    button.classList.add('booked');
                    button.disabled = true;
                }
            });
        });
    });
</script>

</body>
</html>
