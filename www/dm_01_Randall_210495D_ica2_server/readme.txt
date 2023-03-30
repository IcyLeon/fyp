Shop - Buy items only once and cannot buy them again unless player sell them (all items requires player at level 3)
Inventory - able to review items bought from the shop and sell them to earn back half the price and 2 xp
Score - Can only display top 10, leaderboard will update existing username and only if they beat their own highscore. Added rankings based on scores, can be sort by names or scores.  Can also display total time and sort by name or time.

Player stats - Added total time played and lastlogin, update every time when collect/purchase/sell items. All basic stats will be affected on the shop and inventory. Coins and XP for the shop are deducted in the PHP.

Register - Password (10 char minimum), must have email and username. Cannot have same existed username/email.
Delete - player can delete own account in the login page or in game which deletes all their data immediately
Login - Player can create a new password when forgotten which requires existing username

Added AddShoplistBackend.php (tb_shop, create all the neccessary info of the items)
Added AddPlayerInventoryBackend.php (tb_items_inventory)
Added ForgetPasswordBackend.php (for reseting password)
Added ReadPlayerInventory.php (reading player's inventory)

Unity - Using Post function and Get function together
PHP - Inner Join for lastlogin and playerstats together, relevent echo msg, etc.
