<?php if($trips_count > 0): ?>
    <header class="d-flex flex-wrap c_header pl-2 align-content-center">
        <div class="w-100 h-100 d-flex flex-wrap justify-content-between align-content-center p-2">
            <strong>Trips</strong>
            <button onclick="set_session('view=new')" class="btn btn-sm btn_brand rounded-0">
                New Event
            </button>
        </div>
    </header>
    <article class="">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Event Title</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Bookings</th>
                    <th>Views</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                while ($trip = $trips->fetch(PDO::FETCH_ASSOC)):
                    $s_d = explode('-',$trip['start_date']);
                    $s=mktime(0,0,0,$s_d[1], $s_d[2], $s_d[0]);
                    $sd = date("d M Y", $s);
                    $e_d = explode('-',$trip['end_date']);
                    $e=mktime(0,0,0,$e_d[1], $e_d[2], $e_d[0]);
                    $uni = $trip['tour_uni'];
                    $ed = date("d M Y", $e);
                    ?>
                    <tr>
                        <td><?php echo $trip['title'] ?></td>
                        <td><?php echo $sd ?></td>
                        <td><?php echo $ed ?></td>
                        <td>
                            <?php
                                // get bookings
                                $b_count = rowsOf('events_booking',"`event` = '$uni'",$pdo);
                                if($b_count > 0)
                                {
                                    echo "<kbd onclick=\"set_session('view=bookings,event=$uni')\" class='badge-success pointer'>$b_count</kbd>";
                                }
                                else
                                {
                                    echo "<kbd class='badge-secondary'>$b_count</kbd>";
                                }
                            ?>

                        </td>
                        <td><kbd><?php echo $trip['views'] ?></kbd></td>
                        <td>
                            <span onclick="set_session('view=add_images,event=<?php echo $uni ?>')" class="fa fa-picture-o text-success mr-1 pointer" title="Add Images"></span>
                            <span onclick="set_session('view=ytube,event=<?php echo $uni ?>')" class="fa fa-youtube-play text-danger mr-1 pointer" title="Youtube Videos"></span>
                            <span onclick="set_session('view=edit,event=<?php echo $uni ?>')" class="fa fa-pencil text-info mr-1 pointer" title="Edit"></span>

                            <span class="fa fa-trash-o text-danger mr-1 pointer" title="delete" onclick="delete_event('<?php echo $uni ?>')"></span>
                        </td>
                    </tr>


                <?php
                endwhile;
                ?>
                </tbody>
            </table>
        </div>
    </article>
<?php endif; ?>

<?php if($trips_count < 1): ?>
    <div class="w-100 h-100 d-flex flex-wrap align-content-center justify-content-center">
        <div class="w-50 text-center">
            <p onclick="set_session('view=new')" class="enc">Create Event</p>
        </div>
    </div>
<?php endif; ?>

