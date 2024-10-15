<form action="../includes/add_product.inc.php" method="POST" id="productForm">
    <!-- Store selection -->
    <label for="store_id">Store:</label>
    <select name="store_id" required>
        <option value="">Select Store</option>
        <?php
        // Assuming StoreCtrl is a valid class that fetches stores
        $storeCtrl = new StoreCtrl();
        $stores = $storeCtrl->getAllStores();
        foreach ($stores as $store) {
            echo "<option value='{$store['store_id']}'>{$store['store_name']}</option>";
        }
        ?>
    </select>

    <!-- Models selection table -->
    <label for="models">Models:</label>
    <table>
        <thead>
            <tr>
                <th>Select</th>
                <th>Model Name</th>
                <th>Quantity</th>
                <th>Serial Numbers (Optional)</th>
            </tr>
        </thead>
        <tbody id="model-container">
            <?php
            // Assuming ModelCtrl is a valid class that fetches models
            $modelCtrl = new ModelCtrl();
            $models = $modelCtrl->getAllModels();
            foreach ($models as $model) {
                echo "
                <tr>
                    <td><input type='checkbox' name='model_id[]' value='{$model['model_id']}' class='model-checkbox'></td>
                    <td>{$model['model_name']}</td>
                    <td><input type='number' name='model_quantity[{$model['model_id']}]' placeholder='Quantity' min='1' class='model-quantity' disabled></td>
                    <td><textarea name='serial_numbers[{$model['model_id']}]' placeholder='Serial Numbers (Optional)' class='serial-numbers' rows='3' disabled></textarea></td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Submit button -->
    <button type="submit" name="submit">Add Product</button>
</form>

<script>
document.querySelectorAll('.model-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const row = this.closest('tr');
        const quantityInput = row.querySelector('.model-quantity');
        const serialInput = row.querySelector('.serial-numbers');  // Updated for textarea
        
        if (this.checked) {
            quantityInput.disabled = false;
            serialInput.disabled = false;
        } else {
            quantityInput.disabled = true;
            serialInput.disabled = true;
            quantityInput.value = '';  // Clear quantity if unchecked
            serialInput.value = '';    // Clear textarea content if unchecked
        }
    });
});

</script>