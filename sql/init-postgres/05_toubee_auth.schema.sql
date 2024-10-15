\list
\c auth;

DROP TABLE IF EXISTS "users";
CREATE TABLE "public"."users" (
    "id" uuid NOT NULL,
    "email" character varying(128) NOT NULL,
    "password" character varying(256) NOT NULL,
    "role" smallint DEFAULT '0' NOT NULL,
    CONSTRAINT "users_email" UNIQUE ("email"),
    CONSTRAINT "users_id" PRIMARY KEY ("id")
) WITH (oids = false);



INSERT INTO "users" ("id", "email", "password", "role") VALUES
('118a9bca-b30e-360a-9acb-0f44498fa9cb',	'munoz.theophile@laposte.net',	'$2y$10$jdB9eypmLmifN5i5n5IwrOi9G6tySqYhsFAfJhHSgYmldTmuaKd3u',	0),
('bdbc09de-d523-34a5-bec7-743953a7cd2f',	'sgodard@vasseur.com',	'$2y$10$w5DrBc0vbyOyZnuTeNuBAuSCDX2NuSrVQAb9w4bN2FD0otn2tazBW',	0),
('33c59f91-10ff-3e5a-a4dd-ffb5e4d1d513',	'lledoux@dbmail.com',	'$2y$10$3jurBwm79Qc0DacDKeYele9UTwRlEd0Aadk.9lrYUw037cgJ91yZm',	0),
('98c2aeae-a2f1-382c-8c94-65a27d52f991',	'michel.georges@live.com',	'$2y$10$mwnKPXFa0d0FB34g1T8SJeV2VcsS7uJNDX3G7BnFvNKSsUV1l8e3i',	0),
('f930c1de-5fa2-3832-ba7c-b2d05a9dc2d4',	'rmahe@laposte.net',	'$2y$10$YI1njjpuWVSGtavG8zwn.ea06MIh0c1bPebFibyCoSFVjFjRgPxuu',	0),
('5957675b-b7b0-39ba-8b3a-920b2f7a523f',	'gimenez.alphonse@gregoire.com',	'$2y$10$0imxMNucxthxYFG6Xp4IOuO/VDE9Oc56CydZ..GLJRN63xvwmH2ze',	0),
('fd774f03-935f-39f5-ba95-2f01ffee28dd',	'leon.berger@bailly.org',	'$2y$10$zqoHN9o04tK1yve8fDQJMOsxwk8FxHxLtQ0l9XFcrz7ZuLg198wiW',	0),
('b5e1f6a4-cc8a-37b4-b23a-3772c3c30cbf',	'lopes.odette@sanchez.net',	'$2y$10$0taAHnOfVBWOWd4yLV8HT.oFVAzOylbCV1cQ15aOzhktPgsuvhD12',	0),
('9920d017-c728-3859-ab2e-31c4197c10f3',	'louis.arthur@mendes.net',	'$2y$10$vHMzzpN2rk896i5WAb/FBektzlCJGt9nGba8OWYFTZk4Y.wVao/f2',	0),
('ad9bfece-6520-3ff1-b497-f897e5bde84a',	'jean89@vidal.fr',	'$2y$10$rSC.zrWJTIZRELF1SzdZ/.bCKbpS7q5ZihHtFzGbWkiFFj9QF.Aq2',	0),
('438dff6a-4520-3a00-8b2e-16ea002cafef',	'william46@wanadoo.fr',	'$2y$10$r1RNVmpPrmVAryjx6dtXZu1tNRU9.TrsFygA.rg7B3Au1ZltzTW4G',	0),
('751aaf42-f6be-32f3-8a72-14250e710484',	'gturpin@costa.fr',	'$2y$10$Y0laIpLvYU14rXFMG2OAV..GO1kM6bsLcIXr0FiOIJp.coJ4PEQa.',	0),
('d7c22735-2d8a-30bb-bcc0-ab0a2acb56ac',	'henri29@live.com',	'$2y$10$uqcrqRJTV9zC7n81Ox1l0ePNEfCTrqedgmMhfqk0sB2WvopOXK0Qy',	0),
('aed94255-8dd3-378e-87b5-a1cd2d36eb08',	'jmarin@riviere.com',	'$2y$10$CaTTfmPJ5qSkmcERUz8Ul.K4h/W46TjS11ZgS6kSAAD1dCUKNEEnu',	0),
('ce09855e-6a9c-3a69-bb41-19f444ceedd8',	'wlebrun@yahoo.fr',	'$2y$10$fSvn4bnhdiJWg5gVVBcinedWSmYHQVSUMdYSy5Vb2emKJgVQqfxBO',	0),
('5e1837b3-3205-333d-80be-1b6617bacc5b',	'vmartin@hotmail.fr',	'$2y$10$UcjOqsbIf9eDcQYJKZ2UsuuAPDvm/tni3ANb6C6GE0Zp/Ou6iDGlW',	0),
('d48232be-5a3d-3aa6-9877-37f27c305f82',	'sophie.lambert@pineau.fr',	'$2y$10$ULrTSFMFNu072aOzSYsQFee3IpkBGDSbGJ5mnF3tqJFN/dNqyozqK',	0),
('a70dd64e-3b0e-3175-a5f5-d8012dcd8a73',	'nathalie93@sfr.fr',	'$2y$10$0u2nvIoPr3uuWcRMAjX7tedowPkg95TiFnpmbkpHGesG0AuLeInAO',	0),
('a6ace2ea-3bbf-35ca-bf65-1146caa118b6',	'cecile69@boulanger.com',	'$2y$10$SygCY6.efix594JFbNTAdO1/DxYfXJ1Ba0vMHikDeqS2yn22rfQWm',	0),
('74de52df-04ec-3364-bbf4-bf26e191cedb',	'alain15@charrier.fr',	'$2y$10$XGRcgAnLSdpU8Qk6bqRcruw25SoE.K66MksGXVCQw3r2lQv8CPEGy',	0),
('0c89eb6c-55dc-304a-a568-a682c9c6ceef',	'colette58@orange.fr',	'$2y$10$H1pdaffk2W0CdwmJEESsnOpVn1ZTvyAkR4SeJhDOZJEpIo04SpZO2',	0),
('11d611ed-fa3e-39e2-b5e0-018b00cef74a',	'gaillard.martin@deschamps.org',	'$2y$10$xrj.k0zFDLtmoUqLd/kQruRZ8qQVm9Jqo9zTkgSanLpBsTAJz9R4S',	0),
('d785b5be-c84e-3170-adbf-abb636460974',	'matthieu31@hotmail.fr',	'$2y$10$AcX8862cJm8ga7ETqN3C6.xC6HCDHK34xcNpImtpe0h1rZzmavMJO',	0),
('015bf648-9314-31cc-b536-34ad0d043c81',	'lebreton.alfred@dbmail.com',	'$2y$10$Rde/u3/PTR2w0fecg5IrkORrD8ji.IYmPlRFQ3/89uFChlUmagnsO',	0),
('a89bd373-a430-3394-8cbc-8ecd24f436e4',	'adelaide66@club-internet.fr',	'$2y$10$g2s/5AmqNRpCtCnebHbxne3MztlQ1nUBJfprjUWMuS6M8fgDKsBPW',	0),

('c401c65c-8d47-3fab-bab3-c3713a09ce06',	'tvaillant@besson.com',	'$2y$10$QDSXhfn2WMlp6IxONSWwwOFCDIawmnORZXM4KGrLZCirsR32VKen.',	10),
('40708f53-a81b-3f1f-aeed-886ce1e3be60',	'gonzalez.patricia@diaz.fr',	'$2y$10$0AY3fnR1BKX3QCjmjXWkgeV7iBTBNwo/JbRjJ7IM2lVzD6curwRZu',	10),
('d7b34ecf-f3c0-3f2d-84c9-be32f27f1a78',	'rey.alexandre@club-internet.fr',	'$2y$10$kOvoA0w0FfU2H7ZnXci9XeoEZuXrkKWsPmcz4MwNvhlk2cT0tI5jK',	10),
('28b72906-3cbf-3662-8806-b471d873343e',	'dumas.madeleine@leleu.com',	'$2y$10$Ri58fLnU3I9w.PkSXksTkegdf9aKFhp5zfAnE8EKAw/HT5bFh7oLS',	10),
('cf11bb88-f700-3b8e-8c17-745902612058',	'frederique.alexandre@gmail.com',	'$2y$10$6UjiB/OQ678aIaqVhSiBxexMilomwHT9veefT/fv0l2u9ZrJtFMOS',	10),
('011d2c1d-284b-3968-803a-81d25276d93e',	'valette.vincent@brun.com',	'$2y$10$igxaYeerx4lxmOqRifUb6u9riGiLM.2QXJ7nhYdXat20kef.c7UyG',	10),
('ada2fe33-aa08-3d48-b09d-d924c4a8f709',	'egeorges@moulin.fr',	'$2y$10$lXjklmtZ9b.iDSAKiV2iyuTMLr5rajfYgmG673NgfAFz1UheBmCfG',	10),
('3740ce08-d7ed-3f30-89dc-37c75705a5c0',	'pichon.audrey@noos.fr',	'$2y$10$oSRArZ2MLW4mEfHc8HWb6e/cly/hLpapIWXWOwUcl9FC1tnX0xxQm',	10),
('229f36ae-ff42-3b2b-a8bf-e0d90ea46448',	'ebreton@gmail.com',	'$2y$10$BYHfXW75oxcyUG5AuXlYtu6bjUPkGeZltSzn19FSbED77YBHw7BOC',	10),
('387a2731-2dd9-3c14-931f-2b024fa46b27',	'pascal.alexandre@becker.fr',	'$2y$10$8vU2eLuei7ncByKzHMr34uW9C9p5rbDjbtePJYGtBkkwnUUY5Mhcu',	10),
('06624069-b6dc-379a-af32-84b2c7f92703',	'qjoubert@fernandez.com',	'$2y$10$GSa6TjDzRC7XinIUsf73iOaMB.Tws0EB3RKohwJJfQDVpSTChatoW',	10),
('7edc6c16-dfaf-3dd0-b88a-4c3e303cf243',	'nathalie52@vidal.com',	'$2y$10$HeheQbEiMtmCJkM5mwG9O.ZKuJzKfLI2d5wfHVLmeN7k0.zFevyNO',	10),
('cf3dc7df-a4d7-3a8f-9dba-acd4f2d95f1d',	'susan.bonnin@deschamps.fr',	'$2y$10$ixnavMZvartqLWeWU1dCZ.WJi5JUoI7qrij3sIhLpFcVcR5J3SSTi',	10),
('8dcdc828-b90e-30d3-a30a-71890bccb9c3',	'wvallee@club-internet.fr',	'$2y$10$7IFghcui7dIOjSb8AUgcauObIXzzc25UcaTo61w8h0sa8vJDiir3G',	10),
('5991acf8-b757-3556-b1d9-5cfcf52204e0',	'zmichel@salmon.fr',	'$2y$10$oQzBL573aywKWUeWrVhtwu.EZsY2iikWqn7Yu30U5jXtrTjSJDlve',	10),
('dd468533-344d-3141-b6da-945fd273e3f8',	'patrick.sanchez@guilbert.net',	'$2y$10$mywvCQd1WEhjKBGyHwYlfeTbZcU1UX9EzbteeVoMdSOPYX0ZcDx8G',	10),
('656a298f-7f68-3729-b6d4-a015a71192ae',	'charles.bousquet@sfr.fr',	'$2y$10$i0NXAYTXiPtxLMdgSeUWJu1wiyeu.DtR65c4Rp8aN1pPSQb.TJGne',	10),

('a880d501-949d-3912-bbbd-3c9e08aac683',	'bertrand58@petit.fr',	'$2y$10$LApXS4XjXXN8TWSDqNJ8pewXew0j6h7iUO8H5suxpKT7hErdS/hfC',	5),
('26a1dd81-100c-3140-9cab-e2151e0ead08',	'emile.gonzalez@lebrun.net',	'$2y$10$1XMtpKcul060X5zYtNiR5eA5jdYaWcfOzhX41NGywNxZqXxR3hsqK',	5),
('b2a1f915-f2f6-351e-9a4f-43949842b4b8',	'aurelie.nguyen@gmail.com',	'$2y$10$YtX0jmJpY/R6YJtk9u2IMu3Do6KBFfNe5FaHsrtduxUD0X8DELaLS',	5),
('ba055ee7-4cee-317c-8d3d-79dd73db6078',	'robert.morel@fernandez.fr',	'$2y$10$UL12dE7B99GWxF6yTrS4V.AYk8iDJhjavT81H1o9JXIbjlkXpuoda',	5),
('ce7c82fa-a272-3181-887e-09b316c21d92',	'francois.texier@dbmail.com',	'$2y$10$eqiFl6O2WBX2l0aTNh6a8ugfGy/boGDfCbugEIlOjMEUYOxz73k1K',	5),
('048d0b23-56db-34b1-897a-44d7ebd921d6',	'clemence.jourdan@arnaud.com',	'$2y$10$uKhiRAIpLdQnSw/4KcAKwungHfGzxAO99VC9BfEDUwNAnmFV2Tziu',	5),
('3266f07d-a457-350c-99fa-5478fa12c1a4',	'elambert@samson.fr',	'$2y$10$AexAl9Sj5UspIQS2w5hYeeDy6lXKznfSAYBLkfYC/VS12uTb6A5za',	5),
('4f437fb1-c0a0-3b60-b2dc-2cd97b5f7732',	'gilles.hugues@live.com',	'$2y$10$bKncCRi5h1xh7aor/iv8dOARR7gHY.khwAn0WWLkALyChFbeI.mMO',	5),
('a4bf20cd-2c16-3c93-bf30-1c5aa6f9e370',	'eugene76@dossantos.org',	'$2y$10$wndxS.M49JBmAVWMrebYL./rH3qDzwDPHfXpsde9e5M226H5d/PSa',	5),
('ea568716-fbfa-3723-a893-a097061d9a1a',	'christiane.charpentier@langlois.fr',	'$2y$10$yhePSjeofzeSdirvWwvDJODn8XOW4FTy5BAW33Y//5Z9rJwmq1DNO',	5),
('cc27b401-aef3-38a9-8c52-0ec6117f9c67',	'pasquier.leon@girard.com',	'$2y$10$GHKykSHCSrmnjbutTg6ES.aUFhVkEK23q/QhBsfcaEGJvY0a7Rg2i',	5),
('679eaab9-c6a8-3a51-9ebb-8f5a073709d1',	'simone.jacquet@blot.com',	'$2y$10$uA5TwXkF.tKEZEVrgVOZx.0LWG.L4yTAVv0nYDVCz9GDk0pf0p2Ja',	5),
('0a6c75ca-4d2a-3786-92c9-1d5629cc23e2',	'aime92@leclerc.com',	'$2y$10$DkXd5n8ow07ZMQkbCdVS.e76KW8jJefhaFeThsASljLGh702rBbDy',	5),
('a115c355-fc49-3f16-93a9-275ea42ed489',	'bweiss@yahoo.fr',	'$2y$10$6PlgoWDGd2IUdsLxrAObheiTtQyhSIKaDEqapmb/9X1/a1uEiFTfm',	5),
('1016324e-7a32-3fca-9844-6ed51debaefb',	'guillaume.costa@dbmail.com',	'$2y$10$UwhIEYM7.W8YfnmA.R8yHuJIFg1OhRmQldh/XRLIB9oJ865dLP3ly',	5);


