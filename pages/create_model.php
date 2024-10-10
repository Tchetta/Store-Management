<form action="../includes/create_model.inc.php" method="POST" id="modelForm">
    <label for="model_name">Model Name:</label>
    <input type="text" name="model_name" required>

    <label for="number_of_ports">Total Number of Ports:</label>
    <input type="number" name="number_of_ports" id="total_ports" readonly required>

    <label for="brand_id">Brand:</label>
    <select name="brand_id" id="brand_id" required>
        <option value="">Select Brand</option>
        <?php
        // Fetch brands from the database
        $brandCtrl = new BrandCtrl();
        $brands = $brandCtrl->getAllBrands();
        foreach ($brands as $brand) {
            echo "<option value='{$brand['brand_id']}'>{$brand['brand_name']}</option>";
        }
        ?>
    </select>

    <div id="portTypeSection" style="display: none;">
        <h3>Select Port Types and Quantities:</h3>
        <div id="portTypesContainer"></div>
    </div>

    <label for="power_rating">Power Rating:</label>
    <input type="text" name="power_rating">

    <button type="submit" name="submit">Create Model</button>
</form>

<!-- Links to other operations -->
<div>
    <a href="dashboard.php?page=model_list">View All Models</a>
</div>

<script>
// JavaScript to handle brand selection and dynamically load port types
document.getElementById('brand_id').addEventListener('change', function() {
    const brandId = this.value;
    const portTypeSection = document.getElementById('portTypeSection');
    const portTypesContainer = document.getElementById('portTypesContainer');
    const totalPortsField = document.getElementById('total_ports');

    if (brandId) {
        // Make an AJAX call to fetch port types based on the selected brand
        fetch(`../includes/get_port_types.php?brand_id=${brandId}`)
            .then(response => response.json())
            .then(data => {
                // Clear previous port types
                portTypesContainer.innerHTML = '';

                if (data && data.length > 0) {
                    data.forEach(portType => {
                        portTypesContainer.innerHTML += `
                            <label>
                                <input type="checkbox" name="port_types[${portType.port_type_id}]" value="${portType.port_type_id}" class="portTypeCheckbox">
                                ${portType.port_type_name} Quantity:
                                <input type="number" name="quantities[${portType.port_type_id}]" min="0" value="0" class="portTypeQuantity" disabled>
                            </label>
                            <br>
                        `;
                    });
                    portTypeSection.style.display = 'block';
                } else {
                    portTypeSection.style.display = 'none';
                }

                // Add event listeners to update total number of ports
                const checkboxes = document.querySelectorAll('.portTypeCheckbox');
                const quantities = document.querySelectorAll('.portTypeQuantity');

                checkboxes.forEach((checkbox, index) => {
                    checkbox.addEventListener('change', function() {
                        quantities[index].disabled = !checkbox.checked;
                        updateTotalPorts();
                    });
                });

                quantities.forEach(quantity => {
                    quantity.addEventListener('input', updateTotalPorts);
                });

                // Function to update the total number of ports
                function updateTotalPorts() {
                    let totalPorts = 0;
                    quantities.forEach((quantity, index) => {
                        if (!quantities[index].disabled && quantity.value) {
                            totalPorts += parseInt(quantity.value);
                        }
                    });
                    totalPortsField.value = totalPorts;
                }
            });
    } else {
        portTypeSection.style.display = 'none';
        totalPortsField.value = 0;
    }
});
</script>
