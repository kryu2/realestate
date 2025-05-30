<h2>物件の評価レポート</h2>

<h3>この物件の評価用 URL</h3>
<p>
	このリンクをコピーし、メールなどに貼り付けることで、物件情報が入力された状態で『夢のらしんばん』を開くことができます。
</p>

<input type="text" value="<?=$evalUrl ?>" style="width:44em" onFocus="$(this).select();" onClick="$(this).select();" />&nbsp;
<input type="button" value="ｼｮｰﾄURL&QRｺｰﾄﾞ" style="height:28px;" onclick="window.open('http://urx.nu?url=<?=$evalUrl ?>');" />
<h3>評価レポート</h3>

<table class="report">
    <thead>
        <tr>
            <th>融資パターン</th>
            <th>フルローン</th>
            <th>90%ローン</th>
            <th>積算評価額 <small>※1</small></th>
            <th>担保評価額 <small>※2</small></th>
            <th>融資設定の額</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>販売価格</td>
            <td style="text-align:right;"><?=number_format(round($full['retailPrice'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($x90['retailPrice'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($quantity['retailPrice'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($security['retailPrice'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($setting['retailPrice'], -3)) ?></td>
            <td>円</td>
        </tr>

        <tr>
            <td>融資額</td>
            <td style="text-align:right;"><?=number_format(round($full['loanAmount'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($x90['loanAmount'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($quantity['loanAmount'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($security['loanAmount'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($setting['loanAmount'], -3)) ?></td>
            <td>円</td>
        </tr>

        <tr>
            <td>満室時家賃収入</td>
            <td style="text-align:right;"><?=number_format(round($full['fullRentIncome'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($x90['fullRentIncome'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($quantity['fullRentIncome'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($security['fullRentIncome'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($setting['fullRentIncome'], -3)) ?></td>
            <td>円</td>
        </tr>

        <tr>
            <td>表面利回り</td>
            <td style="text-align:right;"><?=round($full['faceYield'],1) ?></td>
            <td style="text-align:right;"><?=round($x90['faceYield'], 1) ?></td>
            <td style="text-align:right;"><?=round($quantity['faceYield'], 1) ?></td>
            <td style="text-align:right;"><?=round($security['faceYield'], 1) ?></td>
            <td style="text-align:right;"><?=round($setting['faceYield'], 1) ?></td>
            <td>%</td>
        </tr>

        <tr>
            <td>正味家賃収入<br />
                ※空室率<?=number_format($setting['emptyRoomRate'], 1) ?>%の場合</td>
            <td style="text-align:right;"><?=number_format(round($full['realIncome'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($x90['realIncome'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($quantity['realIncome'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($security['realIncome'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($setting['realIncome'], -3)) ?></td>
            <td>円</td>
        </tr>

        <tr>
            <td>実質利回り</td>
            <td style="text-align:right;"><?=number_format($full['realYield'], 1) ?></td>
            <td style="text-align:right;"><?=number_format($x90['realYield'], 1) ?></td>
            <td style="text-align:right;"><?=number_format($quantity['realYield'], 1) ?></td>
            <td style="text-align:right;"><?=number_format($security['realYield'], 1) ?></td>
            <td style="text-align:right;"><?=number_format($setting['realYield'], 1) ?></td>
            <td>%</td>
        </tr>

        <tr>
            <td>経費
                <a class="tip" title="経費内訳|
                ※詳細チェック情報が無い場合、満室時家賃収入の15%です<br />
                <br />
                管理費：
                <?=number_format(round($setting['realIncome'] * 6 /100, -3)) ?>円<br />
                修繕費：
                <?=number_format(round($setting['fullRentIncome'] * 5 /100, -3)) ?>円<br />
                固定資産税(建物)：
                <?=number_format(round($setting['buildingPropertyTax'], -3)) ?>円<br />
                固定資産税(土地)：
                <?=number_format(round($setting['groundPropertyTax'], -3)) ?>円<br />
                損害保険料：
                <?=number_format(round($setting['damageInsurance'], -3)) ?>円<br />
                ">?</a>
            </td>
            <td style="text-align:right;"><?=number_format(round($full['cost'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($x90['cost'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($quantity['cost'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($security['cost'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($setting['cost'], -3)) ?></td>
            <td>円</td>
        </tr>

        <tr>
            <td>正味不動産収益(NOI)</td>
            <td style="text-align:right;"><?=number_format(round($full['noi'])) ?></td>
            <td style="text-align:right;"><?=number_format(round($x90['noi'])) ?></td>
            <td style="text-align:right;"><?=number_format(round($quantity['noi'])) ?></td>
            <td style="text-align:right;"><?=number_format(round($security['noi'])) ?></td>
            <td style="text-align:right;"><?=number_format(round($setting['noi'])) ?></td>
            <td>円</td>
        </tr>

        <tr>
            <td>借入金比率(LTV) <a class="tip" title="LTV(Loan to Value)|
                不動産の価格に対する借入金の割合のことです。<br />
                <br />
                100%がフルローンです。
                ">?</a>
            </td>
            <td style="text-align:right;"><?=number_format(round($full['ltv'])) ?></td>
            <td style="text-align:right;"><?=number_format(round($x90['ltv'])) ?></td>
            <td style="text-align:right;"><?=number_format(round($quantity['ltv'])) ?></td>
            <td style="text-align:right;"><?=number_format(round($security['ltv'])) ?></td>
            <td style="text-align:right;"><?=number_format(round($setting['ltv'])) ?></td>
            <td>%</td>
        </tr>

        <tr>
            <td>
                ローン支払額(年/月)<br />
                ※<?=number_format($setting['interestRate'], 1) ?>%、<?=number_format($setting['loanTerm']) ?>年の場合
            </td>
            <td style="text-align:right;">
                <?=number_format(round($full['loanPayment'] * 12, -3)) ?><br />
                <?=number_format(round($full['loanPayment'], -3)) ?>
            </td>
            <td style="text-align:right;">
                <?=number_format(round($x90['loanPayment'] * 12, -3)) ?><br />
                <?=number_format(round($x90['loanPayment'], -3)) ?>
            </td>
            <td style="text-align:right;">
                <?=number_format(round($quantity['loanPayment'] * 12, -3)) ?><br />
                <?=number_format(round($quantity['loanPayment'], -3)) ?>
            </td>
            <td style="text-align:right;">
                <?=number_format(round($security['loanPayment'] * 12, -3)) ?><br />
                <?=number_format(round($security['loanPayment'], -3)) ?>
            </td>
            <td style="text-align:right;">
                <?=number_format(round($setting['loanPayment'] * 12, -3)) ?><br />
                <?=number_format(round($setting['loanPayment'], -3)) ?>
            </td>
            <td>円</td>
        </tr>

        <tr>
            <td>返済余裕率(DSCR) <a class="tip" title="DSCR(Debt Service Coverage Ratio)|
                DSCR = NOI / 年間元利返済額<br />
                年間元利返済額に対して、年間純収益にどれくらいの余裕があるかを表す指標です。<br />
                <br />
                大きいほど安全。<br />
                1.0を下回ると、収益で借入金が返済できなくなります。
                ">?</a>
            </td>
            <td style="text-align:right;"><?=number_format($full['dscr'], 2) ?></td>
            <td style="text-align:right;"><?=number_format($x90['dscr'], 2) ?></td>
            <td style="text-align:right;"><?=number_format($quantity['dscr'], 2) ?></td>
            <td style="text-align:right;"><?=number_format($security['dscr'], 2) ?></td>
            <td style="text-align:right;"><?=number_format($setting['dscr'], 2) ?></td>
            <td></td>
        </tr>

        <tr>
            <th>DSCR評価</th>
            <td class="<?=getSatisfactionLevelByDscr($full['dscr']) ?>">
                <?=getSatisfactionMarkByDscr($full['dscr']) ?>
            </td>
            <td class="<?=getSatisfactionLevelByDscr($x90['dscr']) ?>">
                <?=getSatisfactionMarkByDscr($x90['dscr']) ?>
            </td>
            <td class="<?=getSatisfactionLevelByDscr($quantity['dscr']) ?>">
                <?=getSatisfactionMarkByDscr($quantity['dscr']) ?>
            </td>
            <td class="<?=getSatisfactionLevelByDscr($security['dscr']) ?>">
                <?=getSatisfactionMarkByDscr($security['dscr']) ?>
            </td>
            <td class="<?=getSatisfactionLevelByDscr($setting['dscr']) ?>">
                <?=getSatisfactionMarkByDscr($setting['dscr']) ?>
            </td>
            <td></td>
        </tr>

        <tr>
            <td>キャッシュフロー(年)</td>
            <td style="text-align:right;"><?=number_format(round($full['cf'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($x90['cf'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($quantity['cf'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($security['cf'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($setting['cf'], -3)) ?></td>
            <td>円</td>
        </tr>

        <tr>
            <td>キャッシュフロー(1億当たり)</td>
            <td style="text-align:right;"><?=number_format(round($full['billionCf'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($x90['billionCf'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($quantity['billionCf'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($security['billionCf'], -3)) ?></td>
            <td style="text-align:right;"><?=number_format(round($setting['billionCf'], -3)) ?></td>
            <td>円</td>
        </tr>

        <tr>
            <th>CF評価</th>
            <td class="<?=getSatisfactionLevelByCf($full['billionCf']) ?>">
                <?=getSatisfactionMarkByCf($full['billionCf']) ?>
            </td>
            <td class="<?=getSatisfactionLevelByCf($x90['billionCf']) ?>">
                <?=getSatisfactionMarkByCf($x90['billionCf']) ?>
            </td>
            <td class="<?=getSatisfactionLevelByCf($quantity['billionCf']) ?>">
                <?=getSatisfactionMarkByCf($quantity['billionCf']) ?>
            </td>
            <td class="<?=getSatisfactionLevelByCf($security['billionCf']) ?>">
                <?=getSatisfactionMarkByCf($security['billionCf']) ?>
            </td>
            <td class="<?=getSatisfactionLevelByCf($setting['billionCf']) ?>">
                <?=getSatisfactionMarkByCf($setting['billionCf']) ?>
            </td>
            <td></td>
        </tr>

        <? if (
            $setting['fullRentIncome'] <> '' and
            $setting['totalFloorArea'] <> '' and
            $setting['groundArea'] <> '' and
            $setting['roadRating'] <> ''
        ): ?>

        <tr>
            <td>CFの遷移</td>
            <td style="text-align:center;">
                <form action="<?=base_url() . '../cashflow/' ?>" method="post" name="InputFormFull" id="InputFormFull" target="_blank">
                    <input type="hidden" name="BuildYear" value="<?=$full['buildDate'] ?>" />
                    <input type="hidden" name="PurchaseYear" value="<?=date('Y') ?>" />
                    <input type="hidden" name="RetailPrice" value="<?=$full['retailPrice'] / 10000 ?>" />

                    <input type="hidden" name="FullRentIncome" value="<?=$full['fullRentIncome'] / 10000 ?>" />
                    <input type="hidden" name="EmptyRoomRate" value="<?=$full['emptyRoomRate'] ?>" />
                    <!--input type="hidden" name="IncomeDropRate" value="<?//=$full['incomeDropRate'] ?>" /-->

                    <!--input type="hidden" name="ManageCostRate" value="<?//=$full['manageCostRate'] ?>" /-->
                    <!--input type="hidden" name="RepairCostRate" value="<?//=$full['repairCostRate'] ?>" /-->

                    <!--input type="hidden" name="PublicInterestRate" value="<?//=$full['publicInterestRate'] ?>" /-->

                    <input type="hidden" name="LoanAmount" value="<?=$full['loanAmount'] / 10000 ?>" />
                    <input type="hidden" name="InterestRate" value="<?=$full['interestRate'] ?>" />
                    <input type="hidden" name="LoanTerm" value="<?=$full['loanTerm'] ?>" />
                    <!--input type="hidden" name="SelfFund" value="<?//=$full['selfFund'] ?>" /-->

                    <input type="hidden" name="FrameType" value="<?=$full['frameType'] ?>" />
                    <input type="hidden" name="TotalFloorArea" value="<?=$full['totalFloorArea'] ?>" />

                    <input type="hidden" name="GroundArea" value="<?=$full['groundArea'] ?>" />
                    <input type="hidden" name="RoadRating" value="<?=$full['roadRating'] / 10000?>" />
                    <!--input type="hidden" name="GroundValueDropRate" value="<?//=$full['groundValueDropRate'] ?>" /-->

                    <input type="submit" name="SubmitCFProgress" value="表示" />
                </form>
            </td>
            <td style="text-align:center;">
                <form action="<?=base_url() . '../cashflow/' ?>" method="post" name="InputFormX90" id="InputFormX90" target="_blank">
                    <input type="hidden" name="BuildYear" value="<?=$x90['buildDate'] ?>" />
                    <input type="hidden" name="PurchaseYear" value="<?=date('Y') ?>" />
                    <input type="hidden" name="RetailPrice" value="<?=$x90['retailPrice'] / 10000 ?>" />

                    <input type="hidden" name="FullRentIncome" value="<?=$x90['fullRentIncome'] / 10000 ?>" />
                    <input type="hidden" name="EmptyRoomRate" value="<?=$x90['emptyRoomRate'] ?>" />
                    <!--input type="hidden" name="IncomeDropRate" value="<?//=$x90['incomeDropRate'] ?>" /-->

                    <!--input type="hidden" name="ManageCostRate" value="<?//=$x90['manageCostRate'] ?>" /-->
                    <!--input type="hidden" name="RepairCostRate" value="<?//=$x90['repairCostRate'] ?>" /-->

                    <!--input type="hidden" name="PublicInterestRate" value="<?//=$x90['publicInterestRate'] ?>" /-->

                    <input type="hidden" name="LoanAmount" value="<?=$x90['loanAmount'] / 10000 ?>" />
                    <input type="hidden" name="InterestRate" value="<?=$x90['interestRate'] ?>" />
                    <input type="hidden" name="LoanTerm" value="<?=$x90['loanTerm'] ?>" />
                    <!--input type="hidden" name="SelfFund" value="<?//=$x90['selfFund'] ?>" /-->

                    <input type="hidden" name="FrameType" value="<?=$x90['frameType'] ?>" />
                    <input type="hidden" name="TotalFloorArea" value="<?=$x90['totalFloorArea'] ?>" />

                    <input type="hidden" name="GroundArea" value="<?=$x90['groundArea'] ?>" />
                    <input type="hidden" name="RoadRating" value="<?=$x90['roadRating'] / 10000?>" />
                    <!--input type="hidden" name="GroundValueDropRate" value="<?//=$x90['groundValueDropRate'] ?>" /-->

                    <input type="submit" name="SubmitCFProgress" value="表示" />
                </form>
            </td>
            <td style="text-align:center;">
                <form action="<?=base_url() . '../cashflow/' ?>" method="post" name="InputFormQuantity" id="InputFormQuantity" target="_blank">
                    <input type="hidden" name="BuildYear" value="<?=$quantity['buildDate'] ?>" />
                    <input type="hidden" name="PurchaseYear" value="<?=date('Y') ?>" />
                    <input type="hidden" name="RetailPrice" value="<?=$quantity['retailPrice'] / 10000 ?>" />

                    <input type="hidden" name="FullRentIncome" value="<?=$quantity['fullRentIncome'] / 10000 ?>" />
                    <input type="hidden" name="EmptyRoomRate" value="<?=$quantity['emptyRoomRate'] ?>" />
                    <!--input type="hidden" name="IncomeDropRate" value="<?//=$quantity['incomeDropRate'] ?>" /-->

                    <!--input type="hidden" name="ManageCostRate" value="<?//=$quantity['manageCostRate'] ?>" /-->
                    <!--input type="hidden" name="RepairCostRate" value="<?//=$quantity['repairCostRate'] ?>" /-->

                    <!--input type="hidden" name="PublicInterestRate" value="<?//=$quantity['publicInterestRate'] ?>" /-->

                    <input type="hidden" name="LoanAmount" value="<?=$quantity['loanAmount'] / 10000 ?>" />
                    <input type="hidden" name="InterestRate" value="<?=$quantity['interestRate'] ?>" />
                    <input type="hidden" name="LoanTerm" value="<?=$quantity['loanTerm'] ?>" />
                    <!--input type="hidden" name="SelfFund" value="<?//=$quantity['selfFund'] ?>" /-->

                    <input type="hidden" name="FrameType" value="<?=$quantity['frameType'] ?>" />
                    <input type="hidden" name="TotalFloorArea" value="<?=$quantity['totalFloorArea'] ?>" />

                    <input type="hidden" name="GroundArea" value="<?=$quantity['groundArea'] ?>" />
                    <input type="hidden" name="RoadRating" value="<?=$quantity['roadRating'] / 10000?>" />
                    <!--input type="hidden" name="GroundValueDropRate" value="<?//=$quantity['groundValueDropRate'] ?>" /-->

                    <input type="submit" name="SubmitCFProgress" value="表示" />
                </form>
            </td>
            <td style="text-align:center;">
                <form action="<?=base_url() . '../cashflow/' ?>" method="post" name="InputFormSecurity" id="InputFormSecurity" target="_blank">
                    <input type="hidden" name="BuildYear" value="<?=$security['buildDate'] ?>" />
                    <input type="hidden" name="PurchaseYear" value="<?=date('Y') ?>" />
                    <input type="hidden" name="RetailPrice" value="<?=$security['retailPrice'] / 10000 ?>" />

                    <input type="hidden" name="FullRentIncome" value="<?=$security['fullRentIncome'] / 10000 ?>" />
                    <input type="hidden" name="EmptyRoomRate" value="<?=$security['emptyRoomRate'] ?>" />
                    <!--input type="hidden" name="IncomeDropRate" value="<?//=$security['incomeDropRate'] ?>" /-->

                    <!--input type="hidden" name="ManageCostRate" value="<?//=$security['manageCostRate'] ?>" /-->
                    <!--input type="hidden" name="RepairCostRate" value="<?//=$security['repairCostRate'] ?>" /-->

                    <!--input type="hidden" name="PublicInterestRate" value="<?//=$security['publicInterestRate'] ?>" /-->

                    <input type="hidden" name="LoanAmount" value="<?=$security['loanAmount'] / 10000 ?>" />
                    <input type="hidden" name="InterestRate" value="<?=$security['interestRate'] ?>" />
                    <input type="hidden" name="LoanTerm" value="<?=$security['loanTerm'] ?>" />
                    <!--input type="hidden" name="SelfFund" value="<?//=$security['selfFund'] ?>" /-->

                    <input type="hidden" name="FrameType" value="<?=$security['frameType'] ?>" />
                    <input type="hidden" name="TotalFloorArea" value="<?=$security['totalFloorArea'] ?>" />

                    <input type="hidden" name="GroundArea" value="<?=$security['groundArea'] ?>" />
                    <input type="hidden" name="RoadRating" value="<?=$security['roadRating'] / 10000?>" />
                    <!--input type="hidden" name="GroundValueDropRate" value="<?//=$security['groundValueDropRate'] ?>" /-->

                    <input type="submit" name="SubmitCFProgress" value="表示" />
                </form>
            </td>
            <td style="text-align:center;">
                <form action="<?=base_url() . '../cashflow/' ?>" method="post" name="InputFormSetting" id="InputFormSetting" target="_blank">
                    <input type="hidden" name="BuildYear" value="<?=$setting['buildDate'] ?>" />
                    <input type="hidden" name="PurchaseYear" value="<?=date('Y') ?>" />
                    <input type="hidden" name="RetailPrice" value="<?=$setting['retailPrice'] / 10000 ?>" />

                    <input type="hidden" name="FullRentIncome" value="<?=$setting['fullRentIncome'] / 10000 ?>" />
                    <input type="hidden" name="EmptyRoomRate" value="<?=$setting['emptyRoomRate'] ?>" />
                    <!--input type="hidden" name="IncomeDropRate" value="<?//=$setting['incomeDropRate'] ?>" /-->

                    <!--input type="hidden" name="ManageCostRate" value="<?//=$setting['manageCostRate'] ?>" /-->
                    <!--input type="hidden" name="RepairCostRate" value="<?//=$setting['repairCostRate'] ?>" /-->

                    <!--input type="hidden" name="PublicInterestRate" value="<?//=$setting['publicInterestRate'] ?>" /-->

                    <input type="hidden" name="LoanAmount" value="<?=$setting['loanAmount'] / 10000 ?>" />
                    <input type="hidden" name="InterestRate" value="<?=$setting['interestRate'] ?>" />
                    <input type="hidden" name="LoanTerm" value="<?=$setting['loanTerm'] ?>" />
                    <!--input type="hidden" name="SelfFund" value="<?//=$setting['selfFund'] ?>" /-->

                    <input type="hidden" name="FrameType" value="<?=$setting['frameType'] ?>" />
                    <input type="hidden" name="TotalFloorArea" value="<?=$setting['totalFloorArea'] ?>" />

                    <input type="hidden" name="GroundArea" value="<?=$setting['groundArea'] ?>" />
                    <input type="hidden" name="RoadRating" value="<?=$setting['roadRating'] / 10000?>" />
                    <!--input type="hidden" name="GroundValueDropRate" value="<?//=$setting['groundValueDropRate'] ?>" /-->

                    <input type="submit" name="SubmitCFProgress" value="表示" />
                </form>
            </td>
            <td></td>
        </tr>

        <? endif ?>
    </tbody>

</table>

※計算の前提：
再調達価格<strong><?=$setting['repurchaseCost'] / 10000 ?></strong>万円、
経済耐用年数<strong><?=$setting['economyLifePeriod'] ?></strong>年、
法定耐用年数(居住用)<strong><?=$setting['legalLifePeriodResidence'] ?></strong>年
(事務所用) <strong><?=$setting['legalLifePeriodOffice'] ?></strong>年<br />
※1 積算評価は、
土地の評価額が <strong><?=number_format(round($security['groundPrice'], -3) / 10000) ?></strong> 万円、
建物の評価額が <strong><?=number_format(round($security['buildingPrice'], -3) / 10000) ?></strong> 万円です<br />
※2 担保評価は、
土地担保比率：<strong><?=$security['groundSecurityRate'] ?></strong>、
建物担保比率：<strong><?=$security['buildingSecurityRate'] ?></strong>、
として計算しています

<h3>リスクについて</h3>

<h4>【容積率】</h4>
<? if (is_null($setting['isCapacityOver'])) : ?>
    延床面積、土地面積、容積率を入力してください。<br />
<? elseif ($setting['isCapacityOver']) : ?>
    <span class="caution">容積率オーバー(既存不適格建物、違法建築)の可能性があります。</span><br />
    容積率オーバーの物件では、一般的に融資されません。<br />
    <span class="check">駐車場の面積が計上されていないかなどを確認してください。</span><br />
<? else: ?>
    建物面積は容積率の範囲内ですので、問題なさそうです。<br />
<? endif; ?>


<h4>【道路付け】</h4>
<? switch ($setting['roadBorderCount']) { ?>
<? case 0: ?>
    <span class="caution">銀行は、一般的に接道していない物件に融資を行いません。</span><br />
    接道していても、幅4m未満の道路の場合、建て替える際にセットバックにより土地の一部を失う可能性があります。<br />
    また、物件情報に「42条2項道路」の記述が無い場合はセットバックできず、無道路地(建て替え不可の土地)の可能性があります。
<? break; ?>
<? case 1: ?>
<? case 2: ?>
<? default; ?>
    幅4m以上の道路と接しているので道路付けに問題はなさそうですが、<br />
    道路と土地の接面が2m以上あるかどうかを確認してください。<br />
<? } ?>


<h4>【修繕】</h4>
住居用物件は、大規模な修繕を15年に1度する必要があります。<br />
この物件は築<?=$setting['buildingAge'] ?>年なので、

<? if ($setting['buildingAge'] < 12) : ?>
    大規模修繕が必要になるのはまだ先ですが、修繕の積立を行いましょう。
<? elseif ($setting['buildingAge'] < 15) : ?>
    大規模修繕の時期が近いです。<br />
    修繕積立金で対処できない可能性が高いので、家賃収入からの積み立ても検討しましょう。<br />
<? else : ?>
    <span class="caution">大規模修繕の時期が過ぎています。修繕状況を確認しましょう。</span><br />
    未修繕の場合、購入後に別途修繕費用が必要になる場合があります。<br />

    <? if ($setting['totalFloorArea']) : ?>
        建物の新築価格の10%を大規模修繕費用とした場合、この物件では<?=number_format($setting['repurchaseCost'] * $setting['totalFloorArea'] * 0.1 / 10000) ?>万円かかります。
    <? endif; ?>

<? endif; ?>


<h4>【耐震性】</h4>
<? if (1982 < $setting['buildDate']) : ?>
    1981年6月に施工された現在の耐震基準で設計されたのであれば、問題なさそうです。
<? else : ?>
    <span class="caution">旧耐震で設計されている可能性がありますので、補強工事が必要になる場合があります。</span>
<? endif; ?>


<h4>【アスベスト】</h4>
<? if (1991 < $setting['buildDate']) : ?>
    建築資材からアスベストが排除された1991年以降に建てられたのであれば、問題なさそうです。
<? else : ?>
    <span class="caution">アスベストが使用されている可能性がありますので、解体時に除去費用が必要になる場合があります。出口戦略を考えましょう。</span>
<? endif; ?>


<h4>【1戸当たりの面積】</h4>
<? if ($setting['totalFloorArea'] and $setting['residenceCount']) : ?>
    1戸当たりの面積は、<?=round($setting['totalFloorArea'] / $setting['residenceCount'], 1) ?> m<sup>2</sup>です。<br />
    <? if (18 <= ($setting['totalFloorArea'] / $setting['residenceCount'])) : ?>
        18 m<sup>2</sup>以上ありますので、大きさに問題はなさそうです。
    <? else : ?>
        <span class="caution">18 m<sup>2</sup>未満の物件は、ワンルームでも入居者が入りづらい場合が多いようです。</span>
    <? endif; ?>
<? else : ?>
    延床面積、戸数を入力してください。<br />
<? endif; ?>


		<!--// Google Analytics Start //-->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2672769-1";
urchinTracker();
</script>
    <!--// Google Analytics End //-->
