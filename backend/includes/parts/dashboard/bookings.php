<div class="w-100 h-100 overflow-auto card custom_shadow p-2">
    <?php if($booking_count < 1): ?>
        <div class="w-100 h-100 d-flex flex-wrap align-content-center justify-content-center">
            <p class="enc">No Booking</p>
        </div>
    <?php endif; ?>
    <?php if($booking_count > 0): ?>
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Event</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Package</th>
            </tr>
            </thead>
            <tbody>
                <?php while($book = $booking_query->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                    <td><?php echo $book['client_name'] ?></td>
                    <td>
                        <?php
                            $event = $book['event'];
                            echo fetchFunc('tours',"`tour_uni` = '$event'",$pdo)['title'];
                        ?>
                    </td>
                    <td><?php echo $book['phone_number'] ?></td>
                    <td><?php echo $book['email_address'] ?></td>
                    <td><?php echo $book['booking_package'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>