<div class="flm_wrapper">
    <header>
        <h1>Floating Modal</h1>
        <form method="post" action="admin.php">
            <?php wp_nonce_field(); ?>
            <input type="hidden" name="action" value="flm_activator_button"/>
            <button class="button button-primary"><?= (get_option("flm_status") == 1) ? "Deactivate" : "Activate" ?> Plugin</button>
        </form>
    </header>
    <script>var modalData = null;</script>
    <?php $modalData = get_option("flm_modal_data");
        if ($modalData !== null):
            $modalData = json_decode($modalData, true); ?>
            <script>modalData = <?= json_encode($modalData) ?></script>
        <?php endif;  ?>
    <form method="post" class="flm-form" action="admin.php">
        <?php wp_nonce_field('flm-model-form'); ?>
        <input type="hidden" name="action" value="flm_save_modal_data"/>
        <div class="frm-fields">
            <fieldset class="fieldset">
                <legend>Heading of the modal:</legend>
                <div class="frm-group">
                    <div class="input-field input">
                        <label for="title">title</label>
                        <input type="text" name="title" id="title" class="flm-input" required <?= isset($modalData["title"]) ? 'value="' . $modalData["title"] . '"' : ""; ?>>
                    </div>
                </div>
                <div class="frm-group">
                    <div class="input-field input">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" class="flm-input" <?= isset($modalData["description"]) ? 'value="' . $modalData["description"] . '"' : ""; ?>>
                    </div>
                </div>
                <div class="frm-group">
                    <div class="input-field input">
                        <label for="image">Image Url</label>
                        <input type="url" name="image" id="image" class="flm-input" <?= isset($modalData["image"]) ? 'value="' . $modalData["image"] . '"' : ""; ?>>
                    </div>
                </div>
            </fieldset>
            <fieldset class="fieldset flm-links">
                <legend>Links</legend>

            </fieldset>
            <fieldset class="fieldset">
                <legend>Pages</legend>
                <div class="frm-group">
                    <div class="input-field input">
                        <label for="flm_multiselect">The popup will display in.</label>
                        <select multiple="multiple" id="flm_multiselect" name="page[]">
                            <?php
                            $pages = get_pages();
                            $selectedIdx = [];
                            $frontPage = get_option("page_on_front");
                            $i = 0;
                            foreach ($pages as $page) {
                                $selected = false;
                                if (
                                    (isset($modalData["page"]) &&
                                    in_array($page->ID, $modalData["page"])) ||
                                    $frontPage == $page->ID
                                    ) {
                                    $selected = true;
                                    $selectedIdx[] = $i;
                                }
                                ?>
                                <option value="<?= $page->ID ?>" <?= $selected ? "selected" : ""; ?>><?= $page->post_title ?></option>
                            <?php $i++; 
                        } ?>

                        </select>
                    </div>
                </div>
            </fieldset>
        </div>
        <button class="button button-primary">Save Changes</button>
    </form>
</div>
<link rel="stylesheet" href="<?= FLM_BASE_URL ?>libs/css/style.css">
<script src="<?= FLM_BASE_URL ?>libs/js/index.js"></script>
<script>
    var multiIdx = [<?= implode(",", $selectedIdx) ?>];
</script>