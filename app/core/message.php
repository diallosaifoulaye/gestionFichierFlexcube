<script>
    $(document).ready(function () {
        var message;
        if(parseInt("<?= count($this->_message['MSG_ALERT']) ?>") > 0) {
            message = "<div class='container' style='position: absolute; top: 75px; width: 100%;'><div class='row'><div class='col-md-3'></div><div class='col-md-6'><div id='MSG_ALERT' class='alert alert-<?= $this->_message['MSG_ALERT']['type'] ?> alert-dismissable' role='alert'><div class='text-center'><?= $this->_message['MSG_ALERT']['alert'] ?></div></div></div><div class='col-md-3'></div></div></div>";
            $('body').append(message);
            $.get(racine+"error/unsetMessage/<?= base64_encode('ALERT') ?>", function(data, status){});
        }
        if("<?= strtoupper(ENV) ?>" === "DEV" && parseInt("<?= count($this->_message['MSG_ERROR']) ?>") > 0 && "<?= $this->_message['MSG_ERROR']['type'] ?>" === "sql"){
            message = "<div style='z-index: 9999; position: fixed; left: 0; right: 0; bottom: -19px; width: 100%;'><div class='alert alert-warning alert-dismissable' role='alert'><?= $this->_message['MSG_ERROR']['alert'] ?></div></div>";
            $('body').append(message);
            $.get(racine+"error/unsetMessage/<?= base64_encode('ERROR') ?>", function(data, status){});
        }
        if ('<?= $this->data["modal-controller"] ?>' !== '' && '<?= $this->data["modal-view"] ?>' !== '') {
            openModal('<?= $this->data["modal-controller"] ?>', '<?= $this->data["modal-view"] ?>', '<?= implode("/", \app\core\Utils::setBase64_encode_array($this->data["modal-param"])) ?>');
        }
    });
</script>
<div id="modal-container"></div>