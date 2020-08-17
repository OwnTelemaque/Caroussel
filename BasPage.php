        </td>
        
    </tr>
    <tr class="BasPageold">
            <td>

                <?php
                if($_SESSION['TestConnexion'] == 1)
                { ?>
                <a class="ClairSurFondSombre" href="deconnexion.php">Déconnexion</a>
                <?php
                }
                else
                {
                    ?>
                    <div>&nbsp;</div>
                    <?php
                }
                ?>
            </td>    
            <!--
            <td align="center">
                
                <div>
                    <p class="TexteBasPage">
                        Ce site fonctionne avec les navigateurs Firefox, Google Chrome et Internet Explorer
                    </p>
                </div>            
            
            </td>   
            -->
    </tr>    
</table>    <!-- Fin de la table du tableau principal -->

</body>

</html>
