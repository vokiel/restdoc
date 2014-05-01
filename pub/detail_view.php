<?php defined('DOCROOT') or die ('Direct access denided'); ?>
<div class="row">
    <div class="col-lg-9">
    <p><?php echo nl2br($data["description"]); ?></p>

    <div class="panel">
      <h3>Resource URL</h3>
      <div class="panel-body" class="para">
        <code><?php echo $data["resource_url"] ?></code>
      </div>

    </div>

    <div class="panel">
      <h3>Parameters</h3>
      <table class="table table-responsive table-striped table-hover">
        <thead>
          <tr>
            <th>Parameter</th>
            <th>Description</th>
            <th>Optional</th>
            <th>Default</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($data["parameters"] as $param): ?>
          <tr>
            <td><b><?php echo $param["name"]; ?> </b></td>
            <td><?php echo $param["description"]; ?>  </td>
            <td><?php if ($param["optional"]) { echo "True";} ?></td>
            <td><?php if ($param["default"]) { echo $param["default"]; } ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="panel">
      <h3>Example</h3>

      <dl class="dl-horizontal">
        <dt><?php echo $data["method"]; ?></dt>
        <dd><code><?php echo $data["sample_url"]; ?></code></dd>
      </dl>

      <?php if ( !empty($data["sample_request"]) ): ?>
        <div>
          <h4>Request</h4>
          <pre><?php echo $data["sample_request"]; ?></pre>
        </div>
      <?php endif; ?>

      <?php if ( !empty($data["sample_response"]) ): ?>
        <div>
          <h4>Response</h4>
          <pre><?php echo $data["sample_response"]; ?></pre>
        </div>
      <?php endif; ?>

      <?php if ( !empty($data["sample_error"]) ): ?>
        <div>
          <h4>Error Response</h4>
          <pre><?php echo $data["sample_error"]; ?></pre>
        </div>
      <?php endif; ?>

    </div>
  </div>
  <!-- col-8 -->

  <div class="col-lg-3">
    <h3>Resource Information</h3>
    <table class="table table-hover">
      <tbody>
        <tr>
          <td><b>Response Format</b></td>
          <td><span class="label label-info"><?php echo $data["response_format"]; ?></span></td>
        </tr>
        <tr>
          <td><b>Authentication</b></td>
          <td>
            <?php $label_class = ( strtolower($data["authentication"]) != 'none') ? 'label-warning' : 'label-success'; ?>
            <span class="label <?php echo $label_class; ?>"><?php echo $data["authentication"]; ?></span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>