<?php
header('Access-Control-Allow-Origin: *');
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../function.php';
$func = new \server\func();
//// new post querys
///
///
///

if (isset($_POST['loginin'])) {
    if ($_POST['loginin'] == 'submit') {
        if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] == 'https://comformo.com') {
            $func->loginIn($_POST);
            header('Location: https://cabinet.comformo.com/');
        } else {
            echo json_encode($func->loginIn($_POST), JSON_UNESCAPED_UNICODE);
        }
    } else if ($_POST['loginin'] == 'restore') {
        echo json_encode($func->restorePassword($_POST), JSON_UNESCAPED_UNICODE);
    } else if ($_POST['loginin'] == 'second') {
        unset($_POST['loginin']);
        if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] == 'https://comformo.com') {
            $func->loginInSecond($_POST);
            header('Location: https://cabinet.comformo.com/');
        } else {
            echo json_encode($func->loginInSecond($_POST));
        }

    }
} else if (isset($_POST['register'])) {
    if ($_POST['register'] == 'registerApplicant') {
        if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] == 'https://comformo.com') {
            unset($_POST['register']);
            $func->registerUser($_POST);
            $login = array('email' => $_POST['email'], 'password' => $_POST['pass']);
            $func->loginIn($login);
            header('Location: https://cabinet.comformo.com/');
        } else {
            unset($_POST['register']);
            echo json_encode($func->registerUser($_POST), JSON_UNESCAPED_UNICODE);
        }


    } else if ($_POST['register'] == 'registerManager') {
        unset($_POST['register']);
        echo json_encode($func->managerRegisterUser($_POST), JSON_UNESCAPED_UNICODE);
    }
} else if (isset($_POST['loadJurisdiction']) && $_POST['loadJurisdiction'] == 'true') {
    echo json_encode($func->loadJurisdiction(), JSON_UNESCAPED_UNICODE);
} else if (isset($_POST['changePassword']) && $_POST['changePassword'] == 'true' && isset($_POST['oldPass']) && isset($_POST['NewPass'])) {
    unset($_POST['changePassword']);
    echo json_encode($func->setNewPass($_POST), JSON_UNESCAPED_UNICODE);
} else if (isset($_POST['setUserData']) && $_POST['setUserData'] == 'set') {
    unset($_POST['setUserData']);
    echo json_encode(($func->setUserData($_POST)), JSON_UNESCAPED_UNICODE);
} else if (isset($_POST['CheckCompanyName'])) {
    $companyName = $_POST['CheckCompanyName'];
    $companyCountry = $_POST['CheckCompanyCountry'];
    $result = $func->checkCompanyName($companyName);
    echo json_encode($result, JSON_UNESCAPED_UNICODE);
} else if (isset($_POST['updateCompany'])) {
    $companyId = $_POST['updateCompany'];
    unset($_POST['updateCompany']);
    echo json_encode($func->updateCompany($companyId, $_POST));
} else if (isset($_POST['updateStatusOnly'])) {
    $companyId = $_POST['updateStatusOnly'];
    unset($_POST['updateStatusOnly']);
    echo json_encode($func->updateCompanyStatus($companyId, $_POST));
} else if (isset($_POST['createCompany']) && $_POST['createCompany'] == 'create') {
    unset($_POST['createCompany']);
    echo json_encode($func->createCompany($_POST));
} else if (isset($_POST['myCompanys'])) {
    $applicantId = $_POST['myCompanys'];
    echo json_encode($func->getCompanys($applicantId));
} else if (isset($_POST['loadAgentJurisdiction']) && $_POST['loadAgentJurisdiction'] == 'load') {
    echo json_encode($func->loadAgentJurisdiction());
} else if (isset($_POST['person'])) {
    if ($_POST['person'] == 'add') {
        unset($_POST['person']);
        echo json_encode($func->peopleAdd($_POST));
    } else if ($_POST['person'] == 'load') {
        $companyId = $_POST['companyId'];
        echo json_encode($func->peopleLoad($companyId));
    } else if ($_POST['person'] == 'update') {
        unset($_POST['person']);
        echo json_encode($func->peopleUpdate($_POST));
    } else if ($_POST['person'] == 'addlead') {
        unset($_POST['person']);
        echo json_encode($func->addLead($_POST));
    }
} else if (isset($_POST['avatarSave'])) {
    $imgBase = $_POST['avatarSave'];
    $id = $_POST['userId'];
    echo json_encode($func->avatarSave($imgBase, $id));
} else if (isset($_POST['checkwebsite'])) {
    echo json_encode($func->checkWebsite($_POST['checkwebsite']));
} else if (isset($_POST['messages'])) {
    if ($_POST['messages'] == 'load') {
        $from_id = $_POST['from_id'];
        $my_id = $_POST['my_id'];
        echo json_encode($func->loadMess($from_id, $my_id));
    } else if ($_POST['messages'] == 'save') {
        $from_id = $_POST['from_id'];
        $my_id = $_POST['my_id'];
        $mess = $_POST['mess'];
        echo json_encode($func->saveMess($from_id, $my_id, $mess));
    }
} else if (isset($_POST['MessToSupport'])) {
    echo json_encode($func->SendMessToSupport($_POST));
} else if (isset($_POST['saveCompanyDocs']) && $_POST['saveCompanyDocs'] == 'save') {
    $id = $_POST['companyId'];
    echo json_encode($func->saveCompanyFiles($_FILES, $id));
} else if (isset($_POST['task'])) {
    if ($_POST['task'] == 'add') {
        unset($_POST['task']);
        echo json_encode($func->addTask($_POST, $_FILES));
    } else if ($_POST['task'] == 'loadMy') {
        echo json_encode($func->getMyTasks($_POST['my_id']));
    } else if ($_POST['task'] == 'changeStatus') {
        echo json_encode($func->changeTaskStatus($_POST['id'], $_POST['status']));
    } else if ($_POST['task'] == 'loadFrom') {
        echo json_encode($func->getMyTasks($_POST['my_id'], true));
    } else if ($_POST['task'] == 'loadAll') {
        echo json_encode($func->getAllTasks());
    }
} else if (isset($_POST['companion']) && $_POST['companion'] == 'load') {
    echo json_encode($func->loadCompanion());
} else if (isset($_POST['load'])) {
    if ($_POST['load'] == 'UsersCompanysPeople') {
        echo json_encode($func->getUsersCompanysPeoples());
    } else if ($_POST['load'] == 'UsersAll') {
        echo json_encode($func->loadUsers('all'));
    } else if ($_POST['load'] == 'AllCompanys') {
        echo json_encode($func->loadCompanys());
    } else if ($_POST['load'] == 'usersStatus') {
        echo json_encode($func->loadUsersStatus());
    }

} else if (isset($_POST['getCompanyDocs']) && $_POST['getCompanyDocs'] == 'load') {
    echo json_encode($func->getCompanyDocs($_POST['companyId']));
} else if (isset($_POST['setDocStatus']) && (isset($_POST['docID']))) {
    echo json_encode($func->setDocStatus($_POST['setDocStatus'], $_POST['docID']));
} else if (isset($_POST['getApprovDocs'])) {
    if (isset($_POST['accordion'])) {
        echo json_encode($func->getApprovDocs($_POST['getApprovDocs'], true));
    } else {
        echo json_encode($func->getApprovDocs($_POST['getApprovDocs']));
    }
} else if (isset($_POST['getAllDocs'])) {
    echo json_encode($func->getAllDocs());
} else if (isset($_POST['changeAccompanies'])) {
    echo json_encode($func->setTaskAccompanies($_POST));
} else if (isset($_POST['changeManager'])) {
    echo json_encode($func->setCompanyManager($_POST));
} else if (isset($_POST['getClients'])) {
    $managerId = $_POST['getClients'];
    echo json_encode($func->getClients($managerId));
} else if (isset($_POST['getAllClients'])) {
    echo json_encode($func->getClients('all'));
} else if (isset($_POST['getAllLeads'])) {
    echo json_encode($func->getClients('all', '10'));
} else if (isset($_POST['checkDocsStatus'])) {
    echo json_encode($func->checkPassportStatus($_POST['checkDocsStatus']));
} else if (isset($_POST['maillink'])) {
    $res = $func->getMaillinkInfo($_POST['maillink']);
    if (is_array($res)) {
        echo json_encode($res);
    } else {
        echo json_encode(array('error' => "Link is error"));
    }
} else if (isset($_POST['maillinkGenerate']) && $_POST['maillinkGenerate'] == 'Generate') {
    echo json_encode($func->genNewLink($_POST));
} else if (isset($_POST['getFooterComformo'])) {
    echo $func->getFooterComformo();
} else if (isset($_POST['createZip'])) {
    echo json_encode($func->createZip($_POST['createZip']));
} else if (isset($_GET['emailtest'])) {
    $func->sendTestEmail($_GET['emailtest'], $_GET['what']);
} else if (isset($_POST['invoce'])) {
    if ($_POST['invoce'] == 'add') {
        unset($_POST['invoce']);
        echo json_encode($func->addInvoce($_POST));
    } else if ($_POST['invoce'] == 'getAll') {
        unset($_POST['invoce']);
        echo json_encode($func->getAllInvoce());
    }
}










//// old post querys
//	if (isset($_POST['applicant'])) {
//		if ($_POST['applicant'] == 'agentsave') {
//			$formData = $_POST['formdata'];
//			$jurisdictionId = $_POST['jurisdictionId'];
//			$agentId = $_POST['agentId'];
////        echo '$jurisdictionId='.$jurisdictionId;
////        echo '$agentId='.$agentId;
//			$sql = "INSERT INTO `agentApplicant` (agnetNameId,jurisdictionId,formData) VALUES ('{$agentId}','{$jurisdictionId}','{$formData}');";
//			echo $func->sqlQuery($sql);
//		}
//	} else if (isset($_POST['generalInfo'])) {
//		$posts = $func->strPostToArray($_POST['generalInfo']);
//		$titleArray = $posts['titleArray'];
//		$valueArray = $posts['valueArray'];
//		for ($i = 0; $i < count($titleArray); $i++) {
//			$SET[] = $titleArray[$i] . "=" . $valueArray[$i];
//		}
//		$SET = implode(',', $SET);
////    echo '$SET'.$SET;
//		$sql = "UPDATE `companyinfo` SET " . $SET . ", status='1' WHERE id='" . $_COOKIE['companyId'] . "';";
//		$result = $func->sqlQuery($sql);
//		echo $result;
//	} else if (isset($_POST['companyAdd'])) {
//		if ($_POST['companyAdd'] == 'companyAdd') {
//			$companyName1 = $_POST['companyName1'];
//			$companyName2 = $_POST['companyName2'];
//			$companyName3 = $_POST['companyName3'];
//			$CompanyWebsite = $_POST['CompanyWebsite'];
//			$CompanyEmail = $_POST['CompanyEmail'];
//			$activities = $_POST['activities'];
//			$companyAssets = $_POST['companyAssets'];
//			$PartOfGroup = $_POST['PartOfGroup'];
//			$GroupCompanyName = $_POST['GroupCompanyName'];
//			$GroupIncorporationNumber = $_POST['GroupIncorporationNumber'];
//			$GroupWebsite = $_POST['GroupWebsite'];
//			$GroupActivity = $_POST['GroupActivity'];
//			$GroupRole = $_POST['GroupRole'];
//			$applicantid = base64_decode($_COOKIE['id']);
//			$sql = "INSERT INTO `companyinfo`(
//companyName1,
//companyName2,
//companyName3,
//CompanyWebsite,
//CompanyEmail,
//activities,
//companyAssets,
//PartOfGroup,
//GroupCompanyName,
//GroupIncorporationNumber,
//GroupWebsite,
//GroupActivity,
//GroupRole,
//applicantid
//)VALUES(
//'$companyName1',
//'$companyName2',
//'$companyName3',
//'$CompanyWebsite',
//'$CompanyEmail',
//'$activities',
//'$companyAssets',
//'$PartOfGroup',
//'$GroupCompanyName',
//'$GroupIncorporationNumber',
//'$GroupWebsite',
//'$GroupActivity',
//'$GroupRole',
//'$applicantid'
//)";
//			if ($res = $func->sqlQuery($sql)) {
//				$sql1 = "SELECT id FROM `companyinfo` WHERE companyName1='$companyName1' OR companyName2='$companyName1' OR companyName3='$companyName1' AND CompanyEmail='$CompanyEmail';";
//				if ($res1 = $func->sqlQuery($sql1)) {
//					$func->setCookies('page', '2');
//					$func->setCookies('companyId', base64_encode($res1[0]['id']));
//				}
//				echo "OK";
//			} else {
//				echo "ERROR: Can't Add Data to DB";
//			}
//		}
//	}
//	} else if (isset($_POST['financeInfoSave'])) {
//		$posts = $func->strPostToArray($_POST['financeInfoSave']);
//		$titleArray = $posts['titleArray'];
//		$valueArray = $posts['valueArray'];
//		for ($i = 0; $i < count($titleArray); $i++) {
//			$SET[] = $titleArray[$i] . "=" . $valueArray[$i];
//		}
//		$SET = implode(',', $SET);
////    echo '$SET'.$SET;
//		$sql = "UPDATE `companyinfo` SET " . $SET . ", status='3' WHERE id='" . $_COOKIE['companyId'] . "';";
//		echo $func->sqlQuery($sql);
//	} else if (isset($_POST['HaveAllToShareholder'])) {
//		$companyId = $_POST['HaveAllToShareholder'];
//		$sql = "SELECT * FROM `jurisdiction` WHERE secretary='1' AND id='{$companyId}'";
//		$secretary = $func->sqlQuery($sql);
//		if (is_array($secretary)) {
//			echo 'true';
//		} else {
//			echo 'false';
//		}
//	} else if (isset($_POST['checkApplicant'])) {
//		if ($_POST['checkApplicant'] == 'chekAplicant') {
//			$firstName = strtolower(trim($_POST['firstName']));
//			$lastName = strtolower(trim($_POST['lastName']));
//			$applicantid = base64_decode($_COOKIE['id']);
//			$sql = "SELECT firstName,lastName,id FROM `applicant` WHERE id='{$applicantid}';";
//			$res = $func->sqlQuery($sql);
//			if (is_array($res)) {
//				$row = $res[0];
//				if (strtolower($row['firstName']) == $firstName) {
//					if (strtolower($row['lastName']) == $lastName) {
//						echo 'ok';
//					} else {
//						echo "Last name is BAD";
//					}
//				} else {
//					echo "First name is BAD";
//				}
//			} else {
//				echo "Not Correct";
//			}
//		}
//	} else if ((isset($_POST['SignatureConfirmation'])) && (isset($_POST['signature']))) {
//		$SignatureConfirmation = $_POST['SignatureConfirmation'];
//		$SignatureConfirm = $_POST['SignatureConfirm'];
//		$signatureAccept = $_POST['signatureAccept'];
//		$signature = $_POST['signature'];
//		$applicantid = base64_decode($_COOKIE['id']);
//		$companyId = base64_decode($_COOKIE['companyId']);
//		$sql = "INSERT INTO `applicantSignature`(SignatureConfirmation,SignatureConfirm,signatureAccept,signature,companyId,applicantid)VALUES('{$SignatureConfirmation}','{$SignatureConfirm}','{$signatureAccept}','{$signature}','{$companyId}','{$applicantid}');";
//		$res = $func->sqlQuery($sql);
//		if ($res == 'Sql INSERT is ok') {
//			echo "ok";
//		} else {
//			echo "ERROR DB is OUT";
//		}
//	} else if (isset($_POST['CheckCompanyName'])) {
//		$companyName = $_POST['CheckCompanyName'];
//		$result = $func->checkCompanyName($companyName);
//		echo json_encode($result);
//	} else if (isset($_POST['loginin'])) {
//		if ($_POST['loginin'] == 'submit') {
//			$email = trim(strtolower($_POST['email']));
//			$password = base64_encode(trim(strtolower($_POST['password'])));
//			$sql = "SELECT * FROM `users` WHERE email='{$email}' AND pass='{$password}';";
////			echo $sql."<br><hr>";
//			$res = $func->sqlQuery($sql);
////			print_r($res);
////			echo "<br><hr>";
//			header('Access-Control-Allow-Origin: *');
//			if(is_array($res)){
//				$row = $res[0];
//				$premission_group = $row['premission_group'];
//				$firstname = $row['firstname'];
//				$lastname = $row['lastname'];
//				$email = $row['email'];
//				$ourJurisdiction = $func->loadAgentJurisdiction();
//				$allJurisdiction = $func->loadJurisdictionAgent('array','id,jurisdictionname,code');
////				print_r($allJurisdiction);
//				if ($premission_group == '1') {
//					$func->setCookies('login', true, 4368,'/','localhost:8080');
//					$func->setCookies('loginin', 'seo', 4368,'/','localhost:8080');
//					$func->setCookies('id', $row['id'], 4368,'/','localhost:8080');
//					$func->setCookies('email', $row['email'], 4368,'/','localhost:8080');
//					echo json_encode(array('login'=>true,'loginin'=>'seo','id'=>$row['id'],'email'=>$row['email'],'ourJurisdiction'=>$ourJurisdiction,'allJurisdiction'=>$allJurisdiction));
//				} else if ($premission_group == '3') {
//					$func->setCookies('login', true, 4368,'/','localhost:8080');
//					$func->setCookies('loginin', 'girls', 4368,'/','localhost:8080');
//					$func->setCookies('id', $row['id'], 4368,'/','localhost:8080');
//					$func->setCookies('email',$row['email'], 4368,'/','localhost:8080');
//					echo json_encode(array('login'=>true,'loginin'=>'girls','id'=>$row['id'],'email'=>$row['email'],'ourJurisdiction'=>$ourJurisdiction,'allJurisdiction'=>$allJurisdiction));
//				} else if ($premission_group == '4') {
//					$func->setCookies('login', true, 4368,'/','localhost:8080');
//					$func->setCookies('loginin', 'genmanager', 4368,'/','localhost:8080');
//					$func->setCookies('id',$row['id'], 4368,'/','localhost:8080');
//					$func->setCookies('email', $row['email'], 4368,'/','localhost:8080');
//					echo json_encode(array('login'=>true,'loginin'=>'genmanager','id'=>$row['id'],'email'=>$row['email'],'ourJurisdiction'=>$ourJurisdiction,'allJurisdiction'=>$allJurisdiction));
//				} else if ($premission_group == '5') {
//					$func->setCookies('login', true, 4368,'/','localhost:8080');
//					$func->setCookies('loginin', 'agent', 4368,'/','localhost:8080');
//					$func->setCookies('id', $row['id'], 4368,'/','localhost:8080');
//					$func->setCookies('email', $row['email'], 4368,'/','localhost:8080');
//					$func->setCookies('jurisdictionId', $row['jurisdictionId'], 4368,'/','localhost:8080');
//					$func->setCookies('agentNameId', $row['agentNameId'], 4368,'/','localhost:8080');
//					echo json_encode(array('login'=>true,'loginin'=>'agent','id'=>$row['id'],'email'=>$row['email'],'jurisdictionId'=>$row['jurisdictionId'],'agentNameId'=>$row['agentNameId'],'ourJurisdiction'=>$ourJurisdiction,'allJurisdiction'=>$allJurisdiction));
//				}
////				header('Location: /');
//			}else{
//				$email = str_replace('@', '%40', $email);
//				$sql = "SELECT * FROM `applicant` WHERE email='{$email}' AND password='{$password}';";
////				echo $sql."<br><hr>";
//				$res = $func->sqlQuery($sql);
////				print_r($res);
////				echo "<br><hr>";
//				$ourJurisdiction = $func->loadAgentJurisdiction();
//				$allJurisdiction = $func->loadJurisdictionAgent('array','id,jurisdictionname,code');
//				if(is_array($res)){
//					$row=$res[0];
//					$confirmtime = date("Y-m-d H:i:s");
//					$id = $row['id'];
//					$sql1 = "UPDATE `applicant` SET confirmtime='{$confirmtime}' WHERE id='{$id}'";
//					$func->sqlQuery($sql1);
//					$func->setCookies('id', $row['id'], 4368);
//					$func->setCookies('uniqid', $row['uniqid'], 4368);
//					$func->setCookies('lastName', $row['lastName'], 4368);
//					$func->setCookies('firstName', $row['firstName'], 4368);
//					$func->setCookies('email', $row['email'], 4368);
//					$func->setCookies('loginin', 'account', 4368);
//					echo json_encode(array('login'=>true,'loginin'=>'account','id'=>$row['id'],'email'=>$row['email'],'uniqid'=>$row['uniqid'],'lastName'=>$row['lastName'],'firstName'=>$row['firstName'],'ourJurisdiction'=>$ourJurisdiction,'allJurisdiction'=>$allJurisdiction));
////					header('Location: /');
//				}else {
//					echo json_encode(array('login'=>false));
////					header('Location: /?err=Not correct email or password');
//				}
////				header('Location: /');
//			}
//
//		} else if ($_POST['loginin'] == 'restore') {
//			$email = str_replace('@', '%40', trim(strtolower($_POST['email'])));
//			$sql = "SELECT pass FROM `users` WHERE email='$email';";
//			$res=$func->sqlQuery($sql);
//			if(is_array($res)){
//				$pass = base64_decode($res[0]['pass']);
//			}
//			if ($query = $db->con->query($sql)) {
//				if ($query->num_rows > 0) {
//					$row = $query->fetch_assoc();
//					$message=$func->emailHTML('password','atention','success', 'Hello','Remember your password','Your password is:'.$pass,'//cabinet.vvssll.com');
//					$func->sendEmail($email, '', 'Remember your password', $message);
//							header('Location: /?msg=0');
//						} else {
//							header('Location: /?page=forgot&error=1');
//						}
//					}
//
//		}
//	} else if (isset($_POST['loadUsersToRemoveBlock'])) {
//		$users = $func->loadUsers();
//		if (is_array($users)) {
//			foreach ($users as $user) {
//				echo "<tr>
//								<td>" . $user['id'] . "</td>
//								<td>" . $user['lastname'] . "</td>
//								<td>" . $user['firstname'] . "</td>
//								<td>" . $user['nickname'] . "</td>
//								<td>" . $user['email'] . "</td>
//								<td><a href='/function/get/?removeuser=" . $user['id'] . "'><i class='glyphicon glyphicon-remove'></i> Remove user</a></td>
//							</tr>";
//			}
//		} else {
//			echo "<tr><td colspan='6'>$users</td></tr>";
//		}
//	} else if (isset($_POST['pinapplicant'])) {
//		$userid = $_POST['userid'];
//		$applicantId = $_POST['applicantId'];
//		$CheckOrNot = $_POST['CheckOrNot'];
//		$func->pinApplicantToUser($userid, $applicantId, $CheckOrNot);
//	} else if (isset($_POST['loadUsers'])) {
//		$userid = $_POST['loadUsers'];
//		$func->loadApplicantsView($userid);
//	} else if (isset($_POST['adduser'])) {
//		if ($_POST['adduser'] == 'add') {
//			$email = $_POST['email'];
//			$password = $_POST['password'];
//			$lastname = $_POST['lastname'];
//			$firstname = $_POST['firstname'];
//			$premissionGroup = $_POST['premissionGroup'];
//			$func->AddUser($email, $password, $lastname, $firstname, $premissionGroup);
//		}
//	} else if (isset($_POST['filename'])) {
//		$filename = $_POST['filename'];
//		$filestatus = $_POST['filestatus'];
//		$uniqid = $_POST['uniqid'];
//		$func->saveFileStatus($filename, $filestatus, $uniqid);
//	} else if (isset($_POST['loadJurisdiction'])) {
//		if ($_POST['loadJurisdiction'] == 'load') {
//			$func->loadJurisdiction();
//		}
//	} else if (isset($_POST['savejurisdiction'])) {
//		$jurisdictionName = trim(strtolower($_POST['savejurisdiction']));
//		$func->saveJurisdiction($jurisdictionName);
//	} else if (isset($_POST['JurisdictionAgentload'])) {
//		$func->JurisdictionAgentload();
//	} else if (isset($_POST['saveAgent'])) {
//		$jurisdiction_id = $_POST['Jurisdiction_id'];
//		$agentname = $_POST['name'];
//		$func->saveAgent($jurisdiction_id, $agentname);
//	} else if (isset($_POST['jurisdictionId'])) {
//		$jurisdictionId = $_POST['jurisdictionId'];
//		$func->loadAgentInSelection($jurisdictionId);
//	} else if (isset($_POST['whatpost'])) {
//		$uniqid = $_POST['uniqid'];
//		$applicantid = $_POST['applicantid'];
//		unset($_POST['whatpost']);
//		unset($_POST['applicantid']);
//		unset($_POST['uniqid']);
//		foreach ($_POST as $key => $value) {
//			$keys .= $key . ",";
//			$values .= "'" . base64_encode($value) . "',";
//			$where .= $key . "='" . base64_encode($value) . "' AND ";
//		}
//		$sql = "INSERT INTO `companyinfo` (" . $keys . "uniqid,applicantid) VALUES (" . $values . "'{$uniqid}','{$applicantid}');";
////    echo '$sql='.$sql;
//		$sql2 = "SELECT id FROM `companyinfo` WHERE $where uniqid='{$uniqid}' AND applicantid='{$applicantid}';";
////    echo '$sql2='.$sql2;
//		$query = $func->sqlQuery($sql);
//		$query2 = $func->sqlQuery($sql2);
//		$companyId = $query2[0]['id'];
//		$func->setCookies('companyId', $companyId);
////    echo '$query='.$query;
//		echo json_encode($query);
//	} else if (isset($_POST['removepeople'])) {
//		$id = $_POST['removepeople'];
//		$tableWhere = $_POST['tableWhere'];
//		echo $func->removeUser($id, $tableWhere);
//	} else if (isset($_POST['tableWhere'])) {
//		$tableWhere = $_POST['tableWhere'];
//		$whatDo = $_POST['whatDo'];
//		unset($_POST['tableWhere']);
//		unset($_POST['whatDo']);
//		unset($_POST['sameapp']);
//		foreach ($_POST as $key => $value) {
//			if ($key == 'applicantid') {
//				$keys[] = $key;
//				$values[] = base64_decode($value);
//			} else {
//				$keys[] = $key;
//				$values[] = $value;
//			}
//		}
//		echo $func->dbQuery($whatDo, $keys, $values, $tableWhere);
//	} else if (isset($_POST['getApplicantInfo'])) {
//		$uniqid = $_POST['getApplicantInfo'];
//		echo json_encode($func->getApplicantInfo($uniqid));
//	} else if (isset($_POST['dillegance'])) {
//		$postString = $_POST['dillegance'];
//		$posts = explode('&', $postString);
//		foreach ($posts as $post) {
//			$post = explode('=', $post);
//			$titleArray[] = $post[0];
//			$valueArray[] = "'" . $post[1] . "'";
//		}
//		for ($i = 0; $i < count($titleArray); $i++) {
//			$SET[] = $titleArray[$i] . "=" . $valueArray[$i];
//		}
//		$SET = implode(',', $SET);
//		$sql = "UPDATE `companyinfo` SET " . $SET . ", status='3' WHERE id='" . $_COOKIE['companyId'] . "';";
//		echo $func->sqlQuery($sql);
//	} else if (isset($_POST['declanation'])) {
//		$postString = $_POST['declanation'];
//		$posts = explode('&', $postString);
//		foreach ($posts as $post) {
//			$post = explode('=', $post);
//			$titleArray[] = $post[0];
//			$valueArray[] = "'" . $post[1] . "'";
//		}
//		for ($i = 0; $i < count($titleArray); $i++) {
//			$SET[] = $titleArray[$i] . "=" . $valueArray[$i];
//		}
//		$SET = implode(',', $SET);
////    echo '$SET'.$SET;
//		$sql = "UPDATE `companyinfo` SET " . $SET . ", status='4' WHERE id='" . $_COOKIE['companyId'] . "';";
//		echo $func->sqlQuery($sql);
//	} else if (isset($_POST['messages'])) {
//		if ($_POST['messages'] == 'send') {
//			$from_id = $_POST['from'];
//			$my_id = $_POST['who'];
//			$mess = $_POST['message'];
//			$func->saveMess($from_id, $my_id, $mess);
//		} else if ($_POST['messages'] == 'load') {
//			$from_id = $_POST['from'];
//			$my_id = $_POST['who'];
//			$result = $func->loadMess($from_id, $my_id);
//			if (is_array($result)) {
//				foreach ($result as $val) {
////                echo base64_decode($_COOKIE['id']);
//					if ($my_id != $val['who_send']) {
//						echo "<div class='row' style='height: auto;'><div class='out'><span class='arrow'>&nbsp;</span>" . $val['mess'] . "</div></div>";
//					} else {
//						if ($val['status'] == 'read') {
//							echo "<div class='row' style='height: auto;'><div class='in'><span class='arrow'>&nbsp;</span>" . $val['mess'] . "<div class='mess_status'>√√</div></div></div>";
//						} else if ($val['status'] == 'send') {
//							echo "<div class='row' style='height: auto;'><div class='in'><span class='arrow'>&nbsp;</span>" . $val['mess'] . "<div class='mess_status'>√</div></div></div>";
//						}
//					}
//				}
//			} else {
//				if ($result == 'Error: DB is OUT') {
//					echo $result;
//				} else if ($result == 'empty') {
//					echo "<div class='row'><div class='out'>No message in this conversation<br>Be the first</div></div>";
//				}
//			}
//		} else if ($_POST['messages'] == 'loadAll') {
//			$res['messages'] = $func->checkAllMess(base64_decode($_COOKIE['id']));
//			$res['tasks'] = $func->checkAllTasks(base64_decode($_COOKIE['id']));
//			echo json_encode($res);
//		} else if ($_POST['messages'] == 'attach') {
//			$uniqid = $_COOKIE['uniqid'];
////        print_r($_FILES);
//			if (isset($_FILES['files'])) {
//				$errors = [];
//				$path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $uniqid . '/chatattach/';
////        echo $path;
//				$extensions = ['jpg', 'jpeg', 'png', 'pdf'];
//
//				$all_files = count($_FILES['files']['tmp_name']);
//
//				for ($i = 0; $i < $all_files; $i++) {
//					$file_name = $_FILES['files']['name'];
//					$file_tmp = $_FILES['files']['tmp_name'];
//					$file_type = $_FILES['files']['type'];
//					$file_size = $_FILES['files']['size'];
//					$file_ext = strtolower(end(explode('.', $_FILES['files']['name'])));
//					$type = explode('/', $file_type);
//					$file_name = str_replace(',', ' ', $file_name);
//					$file_name = str_replace('.', '', $file_name);
//					$file_name = str_replace('"', '', $file_name);
//					$file_name = str_replace("'", '', $file_name);
////            echo '$file_name='.$file_name;
//					$file_name = substr($file_name, 0, -3);
//					$file_name = uniqid() . $file_name . '.' . $type[1];
////            echo '$file_name='.$file_name;
//					$file = $path . $file_name;
////            echo 'file ='.$file;
//					if (!in_array($file_ext, $extensions)) {
//						$errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
//					}
//
//					if ($file_size > 41943040) {
//						$errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
//					}
//
//					if (file_exists($file)) {
//						$errors[] = 'File exsits';
//					}
//					if (!file_exists($path)) {
//						mkdir($path);
//					}
//					if (empty($errors)) {
//						move_uploaded_file($file_tmp, $file);
//						$status = $func->saveFileStatus($file_name, 'attachments', $uniqid);
//						$text = explode(' ', $status);
//						echo "<attachments><a href=\'/account/?loadmyfile=" . $text[0] . "\'>" . $text[0] . "</a></attachments>";
//					} else {
//						foreach ($errors as $val) {
//							echo "<span style='color: red'> Error: $file_name $val</span><br>";
//						}
//						$errors = [];
//					}
//				}
//			}
//		}
//	} else if (isset($_POST['tasks'])) {
//		if ($_POST['tasks'] == 'save') {
//			unset($_POST['tasks']);
//			$tasks = $_POST;
//			echo $func->saveTask($tasks);
//		} else if ($_POST['tasks'] == 'changeStatus') {
//			$id = $_POST['id'];
//			$status = $_POST['status'];
//			$func->changeTaskStatus($id, $status);
//		} else if ($_POST['tasks'] == 'loadAll') {
//			echo json_encode($func->getAllActiveTasks());
//		} else if ($_POST['tasks'] == 'loadUserTasks') {
//			$func->viewTasks();
//		} else if ($_POST['tasks'] == 'loadUserTasksFrom') {
//			$func->viewTasks(true);
//		} else if ($_POST['tasks'] == 'addcommit') {
//			unset($_POST['tasks']);
//			$_POST['userIdCommit'] = base64_decode($_COOKIE['id']);
//			$result = $func->postToInsert($_POST);
//			$sql = "INSERT INTO `tasksCommit` (" . $result['keys_string'] . ") VALUES (" . $result['values_string'] . ");";
//			echo $func->sqlQuery($sql);
//		}
//	} else if (isset($_POST['saveAvatar'])) {
//		if ($_POST['saveAvatar'] == 'save') {
//			unset($_POST['saveAvatar']);
//			$_POST['user_table'] = $_COOKIE['loginin'];
//			$_POST['user_id'] = base64_decode($_COOKIE['id']);
//			$sql = "SELECT * FROM `avatar` WHERE user_id='{$_POST['user_id']}' AND user_table='{$_POST['user_table']}';";
//			$result = $func->sqlQuery($sql);
//			if (!is_array($result)) {
//				$href = explode(',', $_POST['href']);
//				$type = explode('/', $href[0]);
//				$type = explode(';', $type[1]);
//				$type = $type[0];
//				$image = imagecreatefromstring(base64_decode($href[1]));
//				$width = 350;
//				$height = 350;
////            header('Content-Type: image/jpeg');
//				list($width_orig, $height_orig) = getimagesizefromstring(base64_decode($href[1]));
//				$ratio_orig = $width_orig / $height_orig;
//				if ($width / $height > $ratio_orig) {
//					$width = $height * $ratio_orig;
//				} else {
//					$height = $width / $ratio_orig;
//				}
//				$image_p = imagecreatetruecolor($width, $height);
//				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
//				ob_start();
//				imagejpeg($image_p, null, 100);
//				$new_image = ob_get_clean();
//				ob_end_clean();
//				$new = 'data:image/jpeg;base64,' . base64_encode($new_image);
//				$_POST['href'] = $new;
//				$res = $func->postToInsert($_POST);
//				$sql = "INSERT INTO `avatar` (" . $res['keys_string'] . ") VALUES (" . $res['values_string'] . ");";
//				echo $func->sqlQuery($sql);
//			} else {
////            echo $_POST['href'];
//				$href = explode(',', $_POST['href']);
//				$type = explode('/', $href[0]);
//				$type = explode(';', $type[1]);
//				$type = $type[0];
//				$image = imagecreatefromstring(base64_decode($href[1]));
//				$width = 350;
//				$height = 350;
////            header('Content-Type: image/jpeg');
//				list($width_orig, $height_orig) = getimagesizefromstring(base64_decode($href[1]));
//				$ratio_orig = $width_orig / $height_orig;
//				if ($width / $height > $ratio_orig) {
//					$width = $height * $ratio_orig;
//				} else {
//					$height = $width / $ratio_orig;
//				}
//				$image_p = imagecreatetruecolor($width, $height);
//				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
//				ob_start();
//				imagejpeg($image_p, null, 100);
//				$new_image = ob_get_clean();
//				ob_end_clean();
//				$new = 'data:image/jpeg;base64,' . base64_encode($new_image);
////            echo $new;
//				$sql = "UPDATE `avatar` SET href='{$new}' WHERE user_id='{$_POST['user_id']}' AND user_table='{$_POST['user_table']}';";
//				echo $func->sqlQuery($sql);
//			}
//		}
//	} else if (isset($_POST['getstart'])) {
//		$id = $_POST['getstart'];
//		$sql = "SELECT id FROM `agent` WHERE jurisdiction_id='{$id}';";
//		echo $func->Agents($sql);
//	}else if(isset($_POST['GetAgent'])){
//		echo $func->GetAgents($_POST['GetAgent']);
//	} else if (isset($_POST['regenerateLink'])) {
//		$email = $_POST['regenerateLink'];
//		$oldLink = $_POST['oldLink'];
//		$sql = "SELECT * FROM `maillink` WHERE email='{$email}' AND link='{$oldLink}';";
//		$data = $func->sqlQuery($sql);
//		if (is_array($data)) {
//			$data = $data[0];
//			$sql = "DELETE FROM `maillink` WHERE email='{$email}' AND link='{$oldLink}';";
//			$delete = $func->sqlQuery($sql);
//			if ($delete == 'Sql DELETE is ok') {
//				$newLink = $func->getGUID();
//				$sql = "INSERT INTO `maillink` (link,active,companyId,email)	 VALUES ('{$newLink}','1','" . $data['companyId'] . "','" . $data['email'] . "');";
//				$result = $func->sqlQuery($sql);
//				if ($result == 'Sql INSERT is ok') {
//					$htmlBody = $func->emailHTML('password', 'checked', 'success', 'Hello!', 'Whe created a new link', 'Go to the site to fill out the declination form', 'http://cabinet.vvssll.com/?link=' . $newLink, '');
//					echo $func->sendEmail($email, '', 'New Declanation link', $htmlBody);
//				}
//			}
//		} else {
//			echo 'Not correct email';
//		}
//	} else if (isset($_POST['checkPeople']) && $_POST['checkPeople'] == 'declanation') {
//		$firstName = $_POST['firstName'];
//		$lastName = $_POST['lastName'];
//		$email = str_replace("@", '%40', $_POST['email']);
//		$companyId = $_POST['companyId'];
//		$sql = "SELECT * FROM `people` WHERE email='{$email}' AND companyId='{$companyId}';";
//		$res = $func->sqlQuery($sql);
//		if (is_array($res)) {
//			if (strtolower($res[0]['firstName']) == $firstName && strtolower($res[0]['lastName']) == $lastName) {
//				echo "ok";
//			}
//		} else {
//			echo 'Not correct info';
//		}
//	} else if (isset($_POST['peopleDeclanation'])) {
//		$postString = $_POST['peopleDeclanation'];
//		$posts = explode('&', $postString);
//		foreach ($posts as $post) {
//			$post = explode('=', $post);
//			$titleArray[] = $post[0];
//			$valueArray[] = "'" . $post[1] . "'";
//		}
//		for ($i = 0; $i < count($titleArray); $i++) {
//			if ($titleArray[$i] != 'email' || $titleArray[$i] != 'companyId') {
//				$SET[] = $titleArray[$i] . "=" . $valueArray[$i];
//			}
//			if ($titleArray[$i] == 'email') {
//				$email = strtolower($valueArray[$i]);
//			}
//			if ($titleArray[$i] == 'companyId') {
//				$companyId = $valueArray[$i];
//			}
//		}
//		$SET = implode(',', $SET);
//		$sql = "UPDATE `people` SET " . $SET . " WHERE email={$email} AND companyId={$companyId};";
//		$result = $func->sqlQuery($sql);
//		echo $result;
//	} else if (isset($_POST['peopleFiles'])) {
//		$companyId = $_POST['companyId'];
//		$email = $_POST['email'];
//		$uniqid = $_POST['uniqid'];
//		if ($_POST['peopleFiles'] == 'save') {
//			$result = '';
//			if (isset($_FILES['files'])) {
//				$errors = [];
//				$path = $_SERVER['DOCUMENT_ROOT'] . '/upload/' . $companyId . '/' . $email . '/';
//				$extensions = ['jpg', 'jpeg', 'png', 'gif'];
//
//				$all_files = count($_FILES['files']['tmp_name']);
//
//				for ($i = 0; $i < $all_files; $i++) {
//					$file_name = $_FILES['files']['name'][$i];
//					$file_tmp = $_FILES['files']['tmp_name'][$i];
//					$file_type = $_FILES['files']['type'][$i];
//					$file_size = $_FILES['files']['size'][$i];
//					$file_ext = strtolower(end(explode('.', $_FILES['files']['name'][$i])));
//
//					$file = $path . $file_name;
//
//					if (!in_array($file_ext, $extensions)) {
//						$errors = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
//					}
//
//					if ($file_size > 2097152) {
//						$errors = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
//					}
//					if (file_exists($file)) {
//						$errors = 'File exsits';
//					}
//					if (!file_exists($path)) {
//						mkdir($path, 0755, true);
//					}
//					if (empty($errors)) {
//						move_uploaded_file($file_tmp, $file);
//						$result = 'ok';
//					}
//				}
//
//				if ($errors) echo json_encode(array('err' => $errors));
//			}
//			echo json_encode(array('mess' => $result));
//		}
//	} else if (isset($_POST['addUserAgent'])) {
//		$posts = $_POST['addUserAgent'];
//		$posts = $func->strPostToArray($posts);
//		$posts['valueArray'][0] = str_replace("'", '', explode('_', $posts['valueArray'][0]));
//		$posts['valueArray'][0][0] = "'" . $posts['valueArray'][0][0] . "'";
//		$posts['valueArray'][0][1] = "'" . $posts['valueArray'][0][1] . "'";
//		for ($i = 0; $i < count($posts['titleArray']); $i++) {
//			if ($posts['titleArray'][$i] == 'AgentsCompany') {
//				$uniqid = $func->getGUID();
//				$title = "agentNameId,jurisdictionId,premission_group,pass";
//				$value = $posts['valueArray'][$i][0] . "," . $posts['valueArray'][$i][1] . ",'5','" . base64_encode($uniqid) . "'";
//			} else if ($posts['titleArray'][$i] == 'email') {
//				$email = $posts['valueArray'][$i];
//				$email = str_replace("'", '', str_replace('%40', '@', $email));
//				$title .= "," . $posts['titleArray'][$i];
//				$value .= ",'" . $email . "'";
//			} else {
//				$title .= "," . $posts['titleArray'][$i];
//				$value .= "," . $posts['valueArray'][$i];
//			}
//		}
////    echo $title.'<hr>'.$value;
//		$sql = "INSERT INTO `users` ($title)VALUES($value);";
//		$result = $func->sqlQuery($sql);
//		if ($result == 'Sql INSERT is ok') {
//			$emailhtml = $func->emailHTML('password', 'success', 'success', 'Hello!', 'Whe create a agent zone', 'Go to agent zone button bellow,<br>Your logo is: ' . $email . '<br>Your password is:' . $pass, 'http://cabinet.vvssll.com', 'All right reserved in 2018©');
//			$result2 = $func->sendEmail($email, $email, 'Your Agent zone is created', $emailhtml);
//		}
//		echo json_encode($res = array('users' => $result, 'mail' => $result2));
//	} else if (isset($_POST['UserAgentLoad'])) {
//		$users = $func->getUserPremission_group();
////    print_r($users);
//		foreach ($users as $user) {
//			$company = $func->getAgentComapanyInfo($user['agentNameId']);
//			$jurisdiction = $func->loadJurisdictionInfo($user['jurisdictionId']);
////        echo ;
//			echo '<tr>
//						<td>' . $user['id'] . '</td>
//						<td>' . $user['email'] . '</td>
//						<td>' . $company[0]['agentname'] . '</td>
//						<td>' . $jurisdiction[0]['jurisdictionname'] . '</td>
//						<td><button onclick=UserAgentRemove("' . $user['id'] . '") class="btn-warning">Remove this Agent</button></td>
//						</tr>';
//		}
//	} else if (isset($_POST['UserAgentRemove'])) {
//		$sql = "DELETE FROM `users` WHERE id='{$_POST['UserAgentRemove']}';";
//		echo $func->sqlQuery($sql);
//	} else if (isset($_POST['changeStatus'])) {
//		$status = $_POST['changeStatus'];
//		$sql = "UPDATE `companyinfo` SET status='{$status}' WHERE id='" . $_COOKIE['companyId'] . "';";
//		echo $func->sqlQuery($sql);
//	} else if (isset($_POST['CheckSign'])) {
//		$companyId = $_POST['CheckSign'];
//		$sql = "SELECT SignatureConfirm,DeclanationSign FROM `people` WHERE companyId='{$companyId}';";
//		$people = $func->sqlQuery($sql);
////    echo count($people);
//		$sql = "SELECT email,lastName,firstName FROM `people` WHERE companyId='{$companyId}' AND SignatureConfirm IS NULL AND DeclanationSign IS NULL;";
//		$notSign = $func->sqlQuery($sql);
//		if (is_array($notSign)) {
//			echo json_encode($result = array('AllCount' => count($people), 'NotSing' => count($notSign), 'NotSingData' => $notSign));
//		} else {
//			echo json_encode($result = array('AllCount' => count($people), 'NotSing' => 0, 'NotSingData' => $notSign));
//		}
//	} else if (isset($_POST['successCompany'])) {
//		if ($_POST['successCompany'] == 'success') {
//			$companyId = $_POST['companyId'];
//			$sql = "UPDATE `companyinfo` SET status='100' WHERE id='{$companyId}';";
//			$company = $func->sqlQuery($sql);
//			$sql = "SELECT * FROM `companyinfo` WHERE id='{$companyId}';";
//			$companyInfo = $func->sqlQuery($sql);
//			$Jurisdiction = $companyInfo[0]['Jurisdiction'];
//			$sql = "SELECT jurisdictionname FROM `jurisdiction` WHERE id='{$Jurisdiction}';";
//			$JurisdictionName = $func->sqlQuery($sql);
////        print_r($JurisdictionName);
//			$date = date("d/m/Y");
//			$shortname = base64_encode('Create a company: ' . $companyInfo[0]['companyName']);
//			$whatDo = base64_encode('create a company by name:' . $companyInfo[0]['companyName'] . ', in the country:' . $JurisdictionName[0]['jurisdictionname']);
//			if ($company == 'Sql UPDATE is ok') {
//				$addTask = array('who' => '4', 'datepickerstart' => $date, 'shortname' => $shortname, 'howSendTask' => 'Applicant', 'whatdo' => $whatDo, 'status' => 'active');
//				$task = $func->addTask($addTask);
//				$func->setCookies('noEdit', 'noEdit');
//			}
//		}
//		echo json_encode(array('company' => $company, 'task' => $task));
//
//	} else if (isset($_POST['messangerGroupSortUpdate'])) {
//		$dataInfo = $_POST['messangerGroupSortUpdate'];
//		$changeIdSelect = $_POST['myid'];
//		echo $func->messangerGroupSortUpdate($changeIdSelect, $dataInfo);
//	} else if (isset($_POST['consumer'])) {
//		if ($_POST['consumer'] == 'new') {
//			$data = $_POST['formdata'];
//			$data = explode('&', $data);
//			foreach ($data as $value) {
//				$value = explode('=', $value);
//				$newData[$value[0]] = $value[1];
//			}
//			$func->saveCompanyAndApplicant($newData);
//		}else if($_POST['consumer']=='exist'){
//			$data = $_POST['formdata'];
////        print_r($data);echo '<br><hr>';
//			$data = explode('&',$data);
////        print_r($data);echo '<br><hr>';
//			foreach ($data as $value){
//				$value = explode('=',$value);
//				$newData[$value[0]]=$value[1];
//			}
////        print_r($newData);echo '<br><hr>';
//			$func->updateApplicantAndAddCompany($newData);
//		}
//	} else if (isset($_POST['taskid']) && isset($_POST['whochange'])) {
//		$taskId = $_POST['taskid'];
//		$who = $_POST['whochange'];
//		$sql = "UPDATE `tasks` SET who='{$who}' WHERE id='{$taskId}';";
//		echo $func->sqlQuery($sql);
//	}else if(isset($_POST['package'])){
//		$package=htmlspecialchars($_POST['package']);
//		$packageSum=htmlspecialchars($_POST['packageSum']);
//		$package=htmlspecialchars($_POST['package']);
//		$services=htmlspecialchars($_POST['services']);
//		$servicesPrice=htmlspecialchars($_POST['servicesPrice']);
//		$totalPrice=htmlspecialchars($_POST['totalPrice']);
//		$id=htmlspecialchars($_POST['id']);
//		$sql = "UPDATE `companyinfo` SET package='{$package}', packageSum='{$packageSum}' , services='{$services}' , servicesPrice='{$servicesPrice}' , totalPrice='{$totalPrice}' WHERE id='{$id}';";
////    echo $sql;
//		echo json_encode($func->sqlQuery($sql));
//	}else {
////    print_r($_POST);
////    header('HTTP/1.0 400 Bad Request', true, 400);
////    die;
//	}