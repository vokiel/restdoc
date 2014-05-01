<?php defined('DOCROOT') or die ('Direct access denided'); ?>

<div class="row">
  <div class="col-lg-8">
    <?php
      $data['description'] = nl2br($data['description']);
      // Remove <br /> from <pre>
      $data['description'] = preg_replace_callback(
        '/<pre>([^`]*?)<\/pre>/',
        function ($matches){
          return preg_replace('#<br\s*/?>#', "", $matches[0]);
        },
        $data['description']
      );
    ?>
    <div><?php echo $data["description"]; ?></div>
  </div>

  <div class="col-lg-4">
    <h3>Parameters</h3>
    <table class="table table-hover">
      <tbody>
        <tr>
          <td><b>API url</b></td>
          <td><code><?php echo $data["api_url"]; ?></code></td>
        </tr>
        <tr>
          <td><b>Format</b></td>
          <td><span class="label label-info"><?php echo $data["response_format"]; ?></span></td>
        </tr>
        <tr>
          <td><b>Version</b></td>
          <td><span class="label label-success"><?php echo $data["version"]; ?></span></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="panel">
      <h3>Resources</h3>
      <table class="table table-responsive table-striped table-hover">
        <thead>
          <tr>
            <th>Resource</th>
            <th>Method</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody>
        <?php
          foreach ($data['apis'] as $api) {
            $token = "#";
            if (array_key_exists("file_name", $api)) {
              $token = base64_encode($api["file_name"]);
            }
            $api_url = $detail_url . $token; ?>
          <tr>
            <td><a href="<?php echo $api_url ?>"><b><?php echo $api["name"] ?> </b></a></td>
            <td><?php echo $api["method"] ?> </td>
            <td><?php echo $api["description"] ?> </td>
          </tr>

          <?php } ?>

        </tbody>
      </table>
    </div>
  </div>
</div>