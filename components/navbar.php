<?php

require_once __DIR__ . '/../init.php';

?>

<nav class="shadow-lg bg-yellow clearfix p-4" x-data="navbar()">
  <h1 class="font-bold text-dark-blue text-xl inline-block ml-4"><a class="cursor-pointer" href="<?php if (!is_logged_in()) {
                                                                                                    url('/');
                                                                                                  } else {
                                                                                                    url('/dashboard.php');
                                                                                                  } ?>">TRUNKMON</a></h1>

  <div id="sidebar" class="float-right cursor-pointer relative mr-4">
    <li class="inline-block mx-2 text-dark-blue cursor-pointer text-dark-blue hidden sm:block cursor-pointer" x-on:click="toggle"><?php echo user('username'); ?>
      <span x-show="!show">&#9660;</span>
      <span x-show="show" style="display:none;">&#9650;</span>
    </li>
    <span class="text-lg cursor-pointer float-right sm:hidden" x-on:click="toggle">☰</span>
    <ul x-show="show" class="absolute right-0 w-64 rounded px-4 py-2 rounded bg-white bg-dark-blue text-yellow" style="top:2em; display:none;">

      <!-- Show username in dropdown when hidden -->

      <li><a href="<?php url('/user/show.php?id=' . user('id')); ?>" class="block sm:hidden inline-block py-2">
          <?php echo user('username'); ?>
        </a>
      </li>


      <!-- User menu -->

      <li>
        <a href="<?php url('/user/edit.php?id=' . user('id')); ?>" class="w-full inline-block py-2">Profile
        </a>
      </li>

      <li>Lines</li>

      <ul class="list-disc pl-4">
        <?php foreach (user('trunklines') as $line) { ?>
          <li><a href="<?php url('/trunklines/show.php?id=' . $line->id); ?>" class="w-full inline-block py-2">
              <?php e($line->name); ?>
            </a></li>

        <?php } ?>
      </ul>



      <!-- Admin menu -->
      <a href="<?php url('/trunklines/index.php'); ?>" class="w-full inline-block py-2  border-t border-white">
        <li>Manage trunklines</li>
      </a>

      <a href="<?php url('/company/index.php'); ?>" class="w-full inline-block py-2">
        <li>Manage companies</li>
      </a>

      <a href="<?php url('/user/index.php'); ?>" class="w-full inline-block py-2">
        <li>Manage user</li>
      </a>
      <!-- End menu admin -->
      <a href="<?php url('/php/logout.php'); ?>" class="w-full inline-block py-2 border-t border-white">
        <li>Log out</li>
      </a>
    </ul>
  </div>
</nav>

<script type="text/javascript">
  function navbar() {
    return {
      show: false,
      toggle() {
        this.show = !this.show;
      }
    }
  }
</script>