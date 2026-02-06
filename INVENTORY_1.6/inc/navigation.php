<li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=categories" class="nav-link nav-categories">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                          Category List
                        </p>
                      </a>
                    </li>

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user/list">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                          User List
                        </p>
                      </a>
                    </li>
                    <!-- Check if user is admin using PHP session before showing Borrow-Reservation link -->
                    <?php if(isset($_SESSION['userdata']) && $_SESSION['userdata']['login_type'] == 1): ?>
                    <li class="nav-item dropdown">
                      <a href="/reservation_system/admin/borrow_reservations.php" class="nav-link nav-borrow_reservations">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>
                          Borrow-Reservation
                        </p>
                      </a>
                    </li>
                    <?php endif; ?>
=======
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=categories" class="nav-link nav-categories">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                          Category List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=suppliers" class="nav-link nav-suppliers">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                          Suppliers
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user/list">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                          User List
                        </p>
                      </a>
                    </li>
