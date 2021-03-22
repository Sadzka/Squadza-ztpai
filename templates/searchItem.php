<form class="search-form">
    <span class="search-title">Search Items</span><br><br>
    
    <div class="search-line">
        <div class="search-text">Name:</div>
        <input type="text"      name="name" class="serach-input">
    </div>

    <div class="search-line">
        <div class="search-text">Item Level:</div>
        <input type="number"    name="ilvmin" class="serach-input search-input-small"> -
        <input type="number" 	name="ilvmax" class="serach-input search-input-small">
    </div>

    <div class="search-line">
        <div class="search-text">Required Level:</div>
        <input type="text"      name="reqlvmin" class="serach-input search-input-small"> -
        <input type="text"      name="reqlvmax" class="serach-input search-input-small">
    </div>

    <br>

    <div class="search-line">
        <div class="search-text">Slot:</div>
        <select name="slot[]" class="search-input-options" size="5" multiple="multiple">
            <option value="Back" class="q0">Back</option>
            <option value="Bag" class="q0">Bag</option>
            <option value="Chest" class="q0">Chest</option>
            <option value="Feet" class="q0">Feet</option>
            <option value="Finger" class="q0">Finger</option>
            <option value="Hands" class="q0">Hands</option>
            <option value="Head" class="q0">Head</option>
            <option value="Off-Hand" class="q0">Held In Off-hand</option>
            <option value="Legs" class="q0">Legs</option>
            <option value="Main Hand" class="q0">Main Hand</option>
            <option value="Neck" class="q0">Neck</option>
            <option value="Off Hand" class="q0">Off Hand</option>
            <option value="One-Hand" class="q0">One-Hand</option>
            <option value="Ranged" class="q0">Ranged</option>
            <option value="Shoulder" class="q0">Shoulder</option>
            <option value="Trinket" class="q0">Trinket</option>
            <option value="Two-Hand" class="q0">Two-Hand</option>
            <option value="Waist" class="q0">Waist</option>
            <option value="Wrist" class="q0">Wrist</option>
        </select>
    </div>

    <br>

    <div class="search-line">
        <div class="search-text">Rarity:</div>
        <select name="rarity[]" class="search-input-options" size="5" multiple="multiple">
            <option value="0" class="q0">Poor</option>
            <option value="1" class="q1">Common</option>
            <option value="2" class="q2">Uncommon</option>
            <option value="3" class="q3">Rare</option>
            <option value="4" class="q4">Epic</option>
            <option value="5" class="q5">Legendary</option>
            <option value="6" class="q6">Golden</option>
        </select>
    </div>
    <input type="hidden" value="search" name="search">
    
    <button class="serach-input-submit"> Search </button>
</form>