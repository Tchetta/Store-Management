<form action="../includes/create_model.inc.php" method="POST" id="modelForm">
    <label for="brand_id">Brand:</label>
    <select name="brand_id" id="brand_id" required>
        <option value="">Select Brand</option>
        <!-- Options populated with PHP -->
        <?php
        $brandCtrl = new BrandCtrl();
        $brands = $brandCtrl->getAllBrands();
        foreach ($brands as $brand) {
            echo "<option value='{$brand['brand_id']}'>{$brand['brand_name']}</option>";
        }
        ?>
    </select>

    <!-- Port Types Container -->
    <div id="portTypesContainer"></div>

    <button type="submit" name="submit">Create Model</button>
</form>

<!-- The JavaScript to handle dynamic loading -->
<script>
document.getElementById('brand_id').addEventListener('change', function() {
    const brandId = this.value;
    const portTypesContainer = document.getElementById('portTypesContainer');

    if (brandId) {
        fetch(`../includes/get_port_types.php?brand_id=${brandId}`)
            .then(response => response.json())
            .then(data => {
                // Clear previous port types
                portTypesContainer.innerHTML = '';

                if (data && data.length > 0) {
                    data.forEach(portType => {
                        portTypesContainer.innerHTML += `
                            <div>
                                <strong>${portType.port_type_name}</strong>: 
                                ${portType.models}
                            </div>
                        `;
                    });
                } else {
                    portTypesContainer.innerHTML = 'No port types available for this brand.';
                }
            });
    } else {
        portTypesContainer.innerHTML = '';
    }
});
</script>
