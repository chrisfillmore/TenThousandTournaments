<h1>
    <?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name']; ?>
</h1>
<h2>Group:
    <?php echo $user['User']['group_id']; ?>
</h2>
<pre><?php echo var_dump($user); ?></pre>