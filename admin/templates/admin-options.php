<form action="" method="post">
    <h3>WooCommerce Integration</h3>
    <p>In order to have WooCommerce work headlessly you need to generate an API-key for it and save this credentials in here.</p>
    <p>You can do that <a href="<?= admin_url('admin.php?page=wc-settings&tab=advanced&section=keys&create-key=1') ?>" target="_blank">in this screen</a>.</p>
    <table class="form-table" role="presentation">
        <tbody>
        <tr>
            <th scope="row">
                <label for="wc_key">API Key</label>
            </th>
            <td>
                <input
                    name="wc_key"
                    type="text"
                    id="wc_key"
                    aria-describedby="wc_key-description"
                    value="<?= SqudeCleanWordpressThemeAdminSettings::getSetting('wc_key') ?>"
                    class="regular-text ltr"
                >
                <p class="description" id="wc_key-description">
                    The WooCommerce key for this site
                </p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="wc_secret">API Secret</label>
            </th>
            <td>
                <input
                    name="wc_secret"
                    type="text"
                    id="wc_secret"
                    aria-describedby="wc_secret-description"
                    value="<?= SqudeCleanWordpressThemeAdminSettings::getSetting('wc_secret') ?>"
                    class="regular-text ltr"
                >
                <p class="description" id="wc_secret-description">
                    The WooCommerce secret for this site
                </p>
            </td>
        </tr>
        </tbody>
    </table>

    <!-- Settings End !-->

    <p class="submit">
        <input type="submit" id="submit" class="button button-primary" value="Save Changes">
    </p>
</form>